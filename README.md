Every local farmer is on

# The Roaming Rooster

[![Push to Infinityfree](https://github.com/d-002/roaming-rooster/actions/workflows/push-to-infinityfree.yml/badge.svg)](https://github.com/d-002/roaming-rooster/actions/workflows/push-to-infinityfree.yml)

## Configuration

### Production

The production website is on Infinityfree, at [this address](http://roaming-rooster.42web.io).

### Debugging

1. **xampp configuration**

- Install [xampp](https://www.apachefriends.org/download.html)
- Open xampp, then open `httpd.conf` in the Apache server Config section:
- Edit the file that opens to contain a link to the project (search for "DocumentRoot"):
```
DocumentRoot "/path/to/roaming-rooster"
<Directory "/path/to/roaming-rooster">
```

2. **php configuration**

- Still in xampp, open Config > `php.ini`
- Search for the line `;extension=pdo_sqlite` and remove the semicolon (`;`) at the start
- Do the same for the line `;extension=sqlite3`

3. **Opening the development website**

- Launch the Apache server in xampp.
- Open the website on the given port, for example [localhost:80](http://localhost:80)
- Push your work on separate branches, not on main


### Files and directories

- The `/private` folder is unaccessible by users. It is used to store sensitive information such as database tables.
- Special error pages exist, such as for 401, 403, 404, 500, and are redirected through `.htaccess` files.
