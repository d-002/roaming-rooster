import os
import sys
from dateutil import parser
from os.path import basename, dirname, join, isdir, getmtime
from ftplib import FTP

# ----- CONFIG -----

ROOT_REMOTE = '/htdocs'
ROOT_LOCAL = '..'
IGNORE_LIST = ['.git', '.github', '.gitignore', 'README.md', '.gitignore', '__pycache__']

ignored = {key: False for key in IGNORE_LIST}

if len(sys.argv) == 3:
    print('Detected github actions mode (login in args)')
    login = tuple(sys.argv[1:])
else:
    print('Detected local run, using cached credentials system')

    import cache_login
    login = cache_login.get_login()

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

# ----- UPLOAD -----

def ignore(path):
    if path in IGNORE_LIST:
        ignored[path] = True
        return True

    return False

def check_all_ignored():
    if False in ignored.values():
        print('WARNING: some blacklisted files were not available', file=sys.stderr)

def list_remote(path, relative_path):
    """recursively find all files and directories inside a remote path,
    and store their paths relative to the remote root"""

    # add the current directory, except for the root 
    files = [] if path == ROOT_REMOTE else [relative_path]

    ftp.cwd(path)
    for (name, properties) in ftp.mlsd(path='.'):
        if name in '..': continue

        file_type = properties['type']

        path_to_file = path+'/'+name
        relative_path_to_file = relative_path+'/'+name

        if file_type == 'file':
            # get the modification date of the file
            time = ftp.voidcmd('MDTM '+path_to_file)[4:].strip()
            timestamp = parser.parse(time).timestamp()

            files.append((path_to_file, timestamp))

        elif file_type == 'dir':
            files += list_remote(path_to_file, relative_path_to_file)
            ftp.cwd(path)

    return files

def list_local(path, relative_path):
    """recursively find all files and directories inside a local path,
    and store their paths relative to the local root"""

    # check for ignored directories names
    if ignore(basename(path)):
        return []

    # add the current directory, except for the root 
    files = [] if path == ROOT_LOCAL else [relative_path]

    for name in os.listdir(path):
        if name in '..': continue

        path_to_file = join(path, name)
        relative_path_to_file = join(relative_path, name)

        if isdir(path_to_file):
            files += list_local(path_to_file, relative_path_to_file)

        # check for ignored filenames
        elif not ignore(name):
            files.append((relative_path_to_file, getmtime(path_to_file)))

    return files

def remove_ftp_dir(path, first_call=False):
    print('Emptying dir', path)

    ftp.cwd(path)
    for (name, properties) in ftp.mlsd(path='.'):
        if name in '..': continue

        ftp.cwd(path)
        file_type = properties['type']

        if file_type == 'file':
            print('  |', ftp.delete(name))
        elif file_type == 'dir':
            remove_ftp_dir(path+'/'+name)

    if not first_call:
        # don't remove root directory
        print('  |', ftp.rmd(path), '(%s)' %basename(path))

def ftp_dir_exists(path):
    files = []
    ftp.retrlines('LIST', files.append)

    for f in files:
        if f.split(' ')[-1] == path and f.upper().startswith('D'):
            return True

    return False

def upload_dir(path, remote_path):
    if ignore(basename(path)):
        return

    ftp.cwd(dirname(remote_path))

    print('Uploading dir "%s" to "%s"...' %(path, remote_path))
    # create directory if missing
    if not ftp_dir_exists(path):
        print('Creating missing remote dir', ftp.mkd(remote_path))

    # populate with files
    for name in os.listdir(path):
        if name in '..': continue

        ftp.cwd(remote_path)
        file = join(path, name)

        if isdir(file):
            upload_dir(file, remote_path+'/'+name)

        elif not ignore(name):
            with open(file, 'rb') as f:
                print('  |', ftp.storbinary('STOR '+name, f).split('\n')[0], '(%s)' %name)

# ----- MAIN -----

if __name__ == '__main__':
    # to do: set up some kind of maintenance state for the website here

    check_ftp()
    print('Listing remote files...')
    remote_files = list_remote(ROOT_REMOTE, '')
    print('Found %d files.' %len(remote_files))

    print('Listing local files...')
    local_files = list_local(ROOT_LOCAL, '')
    print('Found %d files.' %len(local_files))

    print(remote_files)
    print(local_files)

    check_ftp()

    # check if everything was ignored
    for key, value in ignored.items():
        if value: continue
        print('WARNING: a blacklisted file was non-existent:', key, file=sys.stderr)

    quit_ftp()
