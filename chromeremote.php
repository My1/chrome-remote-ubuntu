<?php
#have to hardcode res for now
$res="1920x1080";


$display=substr(getenv("DISPLAY"),1); //remove colon at beginning

//die($display);  

$file=file_get_contents("/opt/google/chrome-remote-desktop/chrome-remote-desktop");

$date=date("Y-m-d_H:i");

$new1=str_replace(<<<'END'
    while os.path.exists(X_LOCK_FILE_TEMPLATE % display):
      display += 1
END
,<<<'END'
#    while os.path.exists(X_LOCK_FILE_TEMPLATE % display):
#      display += 1
END
,$file);

$new2=str_replace(<<<'END'
  def launch_session(self, x_args):
    self._init_child_env()
    self._setup_pulseaudio()
    self._setup_gnubby()
    self._launch_x_server(x_args)
    self._launch_x_session()
END
,<<<'END'
  def launch_session(self, x_args):
    self._init_child_env()
    self._setup_pulseaudio()
    self._setup_gnubby()
#    self._launch_x_server(x_args)
#    self._launch_x_session()
    display = self.get_unused_display_number()
    self.child_env["DISPLAY"] = ":%d" % display
END
,$new1);

$new3=preg_replace('~(DEFAULT_SIZES = ")[0-9,x]+"~',"\${1}$res\"",$new2);

$new4=preg_replace('~(DEFAULT_SIZE_NO_RANDR = ")[0-9x]+"~',"\${1}$res\"",$new3);

$new5=preg_replace('~(FIRST_X_DISPLAY_NUMBER = )\d+~',"\${1}$display",$new4);

$final=$new5;

//only if stuff changed
if(md5_file("/opt/google/chrome-remote-desktop/chrome-remote-desktop")!==md5($final)) {
  //make backup
  file_put_contents("/opt/google/chrome-remote-desktop/chrome-remote-desktop-backup-{$date}",$file);
  file_put_contents("/opt/google/chrome-remote-desktop/chrome-remote-desktop",$final);
}
else die("already done.".PHP_EOL);
?>
