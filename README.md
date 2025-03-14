Every local farmer is on

# The Roaming Rooster

## Configuration

### Production

The production website is on Infinityfree, at [this address](http://roaming-rooster.42web.io).

### Debugging

1. Install [xampp](https://www.apachefriends.org/download.html)
2. Run xampp, then go to Apache > Config > Apache (httpd.conf)
3. Edit the file that opens to contain a link to the project (search for "DocumentRoot"):
```
DocumentRoot "/path/to/roaming-rooster"
<Directory "/path/to/roaming-rooster">
```
4. Open the website on the given port, for example [localhost:80](http://localhost:80)

### Files and directories

- The `/private` folder is unaccessible by users. It is used to store sensitive information such as database tables.
- Special error pages exist, such as for 401, 403, 404, 500, and are redirected through `.htaccess` files.
