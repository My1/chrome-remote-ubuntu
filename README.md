# chrome-remote-ubuntu
if chrome remote doesnt work on your ubuntu this can be used to fix it


Simply said this is inspired from [This post](https://medium.com/@vsimon/how-to-install-chrome-remote-desktop-on-ubuntu-18-04-52d99980d83e) by [Vicken Simonian](https://github.com/vsimon) to get chrome Remote running on \*buntu.


It automatically finds your display based on your environment variables and the rest is static. it also makes backups, and makes sure it actually changed something before making another patch and backup cycle.

This file only needs the resolution you want filled in the top and then does all the monkeypatching for you, sadly, you need root access as Google marks the file with root:root as owner and obviously no one else can write.

##Requirements
just PHP Really, it does not use anything fancy, so it should run on most versions, although you obviously should use a supported version so I just generally say 7.1 or higher for now.

## Usage

it is dead simple just

1) download the php file to whereever you like

2) replace the resolution in

~~~php
$res="1920x1080";
~~~

with what you have on your main display

then we stop the server, run out patcher and start it again.
~~~
/opt/google/chrome-remote-desktop/chrome-remote-desktop --stop
php /path/to/chromeremote.php
opt/google/chrome-remote-desktop/chrome-remote-desktop --start
~~~

if it says it isnt even running when trying to stop it no problem, just means it already did what we wanted.
