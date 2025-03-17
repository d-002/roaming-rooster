import os
import sys
from os.path import basename, dirname, join, isdir
from ftplib import FTP

# ----- CONFIG -----

HOME_DIR = '/htdocs'
IGNORE_LIST = ['.git', '.github', '.gitignore', 'README.md', '.gitignore', '__pycache__']

ignored = {key: False for key in IGNORE_LIST}

if len(sys.argv) == 3:
    print('Detected github actions mode (login in args)')
    login = tuple(sys.argv[1:])
else:
    import cache_login

    print('Detected local run, using cached credentials system')
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
    check_ftp()
    print('Logged in.')

    # to do: set up some king of maintenance state for the website here

    print('Emptying contents...')
    remove_ftp_dir(HOME_DIR, True)
    print('Done.\n')

    print('Uploading...')
    upload_dir('..', HOME_DIR)
    print('\nDone.\n')

    # check if everything was ignored
    for key, value in ignored.items():
        if value: continue
        print('WARNING: a blacklisted file was non-existent:', key, file=sys.stderr)

    quit_ftp()
