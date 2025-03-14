import os
from os.path import join, exists, dirname, isdir

import sys
import time
import pickle

def err(code, *args):
    print(' '.join(str(a) for a in args), file=sys.stderr)
    exit(code)

# password storage setup
try:
    if sys.platform.startswith('win'):
        temp_path = os.getenv('temp')
    else:
        temp_path = '/tmp'
except Exception as e:
    err(1, 'Could not find a temp folder:', e)

temp_path = join(temp_path, 'roaming-rooster')

LOGIN_FILE = join(temp_path, 'login')
TSTAMP_FILE = join(temp_path, 'timestamp')
TIMEOUT = 86400 * 30

print('Using files: %s\n             %s\n' %(LOGIN_FILE, TSTAMP_FILE))

def get_login():
    # utils functions
    def update_time():
        with open(TSTAMP_FILE, 'wb') as f:
            pickle.dump(time.time(), f)

    def mkdir(*path):
        for p in path:
            p = dirname(p)
            if not (exists(p) and isdir(p)):
                os.makedirs(p)

    if exists(LOGIN_FILE) and exists(TSTAMP_FILE):
        try:
            with open(TSTAMP_FILE, 'rb') as f:
                tstamp = pickle.load(f)

            if time.time() - tstamp < TIMEOUT:
                with open(LOGIN_FILE, 'rb') as f:
                    login = pickle.load(f)
                update_time()

                print('Using cached login info (%s, ********)\n' %login[0])

                return login
            else:
                print('Login info expired')
        except Exception as e:
            print('Failed to load login:', e)
    else:
        print('Could not find cache files')

    # login could not be loaded, ask again
    username = input('Username: ')
    password = input('Password: ')
    login = (username, password)

    mkdir(LOGIN_FILE, TSTAMP_FILE)

    with open(LOGIN_FILE, 'wb') as f:
        pickle.dump(login, f)
    update_time()
    print('Updated cache files\n')

    return login

get_login()
