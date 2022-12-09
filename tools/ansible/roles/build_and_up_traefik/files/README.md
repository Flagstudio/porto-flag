# Traefik Router

## Add users for basic auth
- Generate new `user` and `password` by `htpasswd`
    + `htpasswd -nb username password`
- If `command not found`, make install `apache2-utils` and try again
    + `apt update && apt install apache2-utils`
- A string like this will be generated
    + `username:$apr1$1gaFt.om$wBpJqtbdwTYFKHz7i/7751`
- Just add this string to the file `data/.usersfile` and save changes
