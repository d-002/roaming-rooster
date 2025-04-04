import os
import sys
from os.path import basename, dirname, isdir, getmtime

from dateutil import parser
from ftplib import FTP

from urllib.error import HTTPError
from urllib.request import Request, urlopen
import json

# ----- CONFIG -----

# will not use os.path.join() to keep paths with a slash for easier conversion
ROOT_REMOTE = '/htdocs'
ROOT_LOCAL = None
IGNORE_LIST = ['.git', '.github', '.gitignore', 'README.md']

ignored = {key: False for key in IGNORE_LIST}

if len(sys.argv) == 5:
    token = sys.argv[3]

    with os.popen('git rev-parse --abbrev-ref HEAD') as p:
        current_branch = p.read().strip()

    print('Current branch:', current_branch)

    base_url = 'https://api.github.com/repos/d-002/roaming-rooster/commits'

    # get list of modified files in this commit
    try:
        url = f"{base_url}?sha={current_branch}&per_page=1"
        headers = {"Authorization": f"token {token}"}

        with urlopen(Request(url, headers=headers)) as response:
            data = json.loads(response.read())[0]

        sha = data["sha"]
        time = data["commit"]["author"]["date"]
        COMMIT_TIME = parser.parse(time).timestamp()

        url = f"{base_url}/{sha}"

        with urlopen(Request(url, headers=headers)) as response:
            files = json.loads(response.read())["files"]

        GIT_MODIFIED_FILES = [ROOT_REMOTE+'/'+file['filename']
                              for file in files
                              if file['status'] == 'modified']

        print(sha, COMMIT_TIME, GIT_MODIFIED_FILES)

    except HTTPError as e:
        print('Could not access repo through GitHub API.', file=sys.stderr)
        print('Make sure a valid token has been provided.', file=sys.stderr)
        print('Reason:', e.code, e.reason, file=sys.stderr)
        exit(1)
    finally:
        del token

    print('Detected github actions mode (login in args)')
    print('Will use last git modification date for updating')
    login = tuple(sys.argv[1:3])
    ROOT_LOCAL = sys.argv[4]
    IS_LOCAL = False

else:
    if len(sys.argv) == 1:
        print('WARNING: automatically setting local path to ".."')
        sys.argv.append('..')

    print('Detected local run, using cached credentials system')
    print('Will use local files modification date for updating')
    ROOT_LOCAL = sys.argv[1]
    IS_LOCAL = True

    import cache_login
    login = cache_login.get_login()

# add files in gitignore to ignore list (but ignore regex)
added = []
with open(ROOT_LOCAL+'/.gitignore') as f:
    for line in f.read().split('\n'):
        if '*' in line: continue
        if not line: continue

        added.append(line)

IGNORE_LIST += added
print('Added paths from gitignore to ignore list:')
for a in added:
    print(' - '+a)
print()

# ----- FTP -----

ftp = None
def check_ftp():
    # handle timeouts

    global ftp
    retry = True

    if ftp is not None:
        try:
            ftp.voidcmd('NOOP')
            retry = False
        except:
            pass

    if retry:
        print('Logged in')
        ftp = FTP('ftpupload.net')
        ftp.login(*login)

    return ftp

def quit_ftp():
    global ftp

    if ftp is None:
        return

    try:
        ftp.quit()
        ftp = None
    except:
        pass

# ----- IGNORE UTILS -----

def ignore(path):
    if path in IGNORE_LIST:
        ignored[path] = True
        return True

    return False

def check_all_ignored():
    if False in ignored.values():
        print('WARNING: some blacklisted files were not available',
              file=sys.stderr)

# ----- LISTING -----

def list_remote(path, relative_path):
    """recursively find all files and directories inside a remote path,
    and store their paths relative to the remote root"""

    # add the current directory, except for the root 
    files = {} if path == ROOT_REMOTE else {relative_path: (0, True)}

    ftp.cwd(path)
    for (name, properties) in ftp.mlsd(path='.'):
        if name in '..': continue

        file_type = properties['type']

        path_to_file = path+'/'+name
        # build relative path, but do not start with a slash
        if relative_path:
            relative_path_to_file = relative_path+'/'+name
        else:
            relative_path_to_file = name

        if file_type == 'file':
            # get the modification date of the file
            time = ftp.voidcmd('MDTM '+path_to_file)[4:].strip()
            time = parser.parse(time).timestamp()

            files[relative_path_to_file] = (time, False)

        elif file_type == 'dir':
            # python 3.9+
            files |= list_remote(path_to_file, relative_path_to_file)
            ftp.cwd(path)

    return files

def list_local(path, relative_path):
    """recursively find all files and directories inside a local path,
    and store their paths relative to the local root"""

    # check for ignored directories names
    if ignore(basename(path)):
        return {}

    # add the current directory, except for the root.
    # directories are added before the files inside,
    # the files list should not be reorganized
    # to avoid remote "path not found" errors
    files = {} if path == ROOT_LOCAL else {relative_path: (0, True)}

    for name in os.listdir(path):
        if name in '..': continue

        path_to_file = path+'/'+name
        # build relative path, but do not start with a slash
        if relative_path:
            relative_path_to_file = relative_path+'/'+name
        else:
            relative_path_to_file = name

        if isdir(path_to_file):
            # python 3.9+
            files |= list_local(path_to_file, relative_path_to_file)

        # check for ignored filenames
        elif not ignore(name):
            if IS_LOCAL:
                # get last file modification time
                time = os.path.getmtime(path_to_file)
            else:
                # get last modification timestamp in the repo
                if path_to_file in GIT_MODIFIED_FILES:
                    time = COMMIT_TIME
                else:
                    time = 0 # don't udpate this file

            files[relative_path_to_file] = (time, False)

    return files

# ----- REMOTE UTILS -----

def create_remote_file(local_path, remote_path):
    with open(local_path, 'rb') as f:
        ftp.storbinary('STOR '+remote_path, f)

def create_remote_dir(remote_path):
    ftp.mkd(remote_path)

def remove_remote_file(path):
    ftp.delete(path)

def remove_remote_dir(path, ignore):
    """recursively delete a remote directory, but also update the files list
    since files and subfolders inside the current directory also get deleted"""

    ftp.cwd(path)
    for (name, properties) in ftp.mlsd(path='.'):
        if name in '..': continue

        ftp.cwd(path)
        file_path = path+'/'+name
        file_type = properties['type']

        if file_type == 'file':
            ftp.delete(name)
            ignore.add(file_path)
        elif file_type == 'dir':
            remove_remote_dir(file_path, ignore)

    ftp.rmd(path)
    ignore.add(path)

# ----- SYNC -----

def sync(remote, local):
    # cache select data, but avoid duplicates and sort
    # (directories first, lowest to highest depth)
    all_items = set(remote.items()) | set(local.items())
    all = {file: file_is_dir for file, (_, file_is_dir) in all_items}
    all = sorted(all.items(), key=lambda x: -1000 * x[1] + len(x[0]))

    # some files and directories can be silently (recursively) deleted,
    # put them here to avoid processing them in the loop
    ignore = set()

    for file, file_is_dir in all:
        remote_path = ROOT_REMOTE+'/'+file
        local_path = ROOT_LOCAL+'/'+file

        if remote_path in ignore: continue

        is_remote = file in remote
        is_local = file in local

        # handle files turned into directories and the opposite
        if is_remote and is_local:
            is_remote_dir = remote[file][1]
            if is_remote_dir != local[file][1]:
                if is_remote_dir:
                    print('Detected dir -> file for', remote_path)
                    remove_remote_dir(remote_path, ignore)
                    create_remote_file(local_path, remote_path)
                else:
                    print('Detected file -> dir for', remote_path)
                    remove_remote_file(remote_path)
                    create_remote_dir(remote_path)

        # handle adding, deleting and updating files and directories
        if file_is_dir:
            if is_remote == is_local:
                continue

            if is_remote:
                print('Deleting outdated tree  ', remote_path)
                remove_remote_dir(remote_path, ignore)
            else:
                print('Creating new dir        ', remote_path)
                create_remote_dir(remote_path)
        else:
            if is_remote and is_local:
                remote_t = remote[file][0]
                local_t = local[file][0]

                if remote_t >= local_t:
                    continue

                # update file
                print('Updating file           ', remote_path)
                create_remote_file(local_path, remote_path)

            elif is_remote:
                print('Deleting outdated file  ', remote_path)
                remove_remote_file(remote_path)

            elif is_local:
                print('Creating new file       ', remote_path)
                create_remote_file(local_path, remote_path)

# ----- MAIN -----

if __name__ == '__main__':
    # to do: set up some kind of maintenance state for the website here

    check_ftp()
    print('\nListing remote files...')
    remote_files = list_remote(ROOT_REMOTE, '')
    print(f'Found {len(remote_files)} files.')

    print('\nListing local files...')
    local_files = list_local(ROOT_LOCAL, '')
    print(f'Found {len(local_files)} files.')

    check_ftp()
    print('\nChecking for and making changes...')
    sync(remote_files, local_files)
    print('Done.')

    del login

    # check if everything was ignored
    for key, value in ignored.items():
        if value: continue
        print('WARNING: a blacklisted file was non-existent:',
              key, file=sys.stderr)

    quit_ftp()
