import sys
from os.path import basename
from ftplib import FTP

# ----- CONFIG -----

IGNORE_LIST = ['.gitignore', 'README.md']

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
        ftp.cwd('/htdocs')

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
    if basename(path) in IGNORE_LIST:
        ignored[path] = True

def check_all_ignored():
    if False in ignored.values():
        print('WARNING: some blacklisted files were not available', file=sys.stderr)

def upload_dir(path):
    pass

# ----- MAIN -----

if __name__ == '__main__':
    check_ftp()

    print(ftp.retrlines('LIST'))

    print('Uploading...')
    upload_dir('.')
    print('\nDone.\n')

    # check if everything was ignored
    for key, value in ignored:
        if value: continue
        print('WARNING: a blacklisted file was non-existent:', key, file=sys.stderr)

    quit_ftp()
