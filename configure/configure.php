<?php

// we begin by initializing ncurses

$ncurse = ncurses_init();

// let ncurses know we wish to use the whole screen

$fullscreen = ncurses_newwin ( 0, 0, 0, 0); 

// draw a border around the whole thing.

ncurses_border(0,0, 0,0, 0,0, 0,0);


ncurses_refresh();// paint both windows

// move into the small window and write a string
$i = 1;
ncurses_mvwaddstr($fullscreen, $i++, 1, "USE SSL \t\t[ ]");
ncurses_mvwaddstr($fullscreen, $i++, 1, "USE EMAIL \t\t[ ]");
ncurses_mvwaddstr($fullscreen, $i++, 1, "USE GCAL \t\t[ ]");

ncurses_mvwaddstr($fullscreen, $i++, 1, "MYSQL DB NAME \t\t[ ]");
ncurses_mvwaddstr($fullscreen, $i++, 1, "MYSQL DB USER \t\t[ ]");
ncurses_mvwaddstr($fullscreen, $i++, 1, "MYSQL DB PASSWORD \t[ ]");
ncurses_mvwaddstr($fullscreen, $i++, 1, "MYSQL DB LOCATION \t[ ]");
ncurses_mvwaddstr($fullscreen, $i++, 1, "DEFAULT_STATE \t\t[ ]");
ncurses_mvwaddstr($fullscreen, $i++, 1, "COUNTY \t\t[ ]");

//next page will set time zone, and presend options for type of email to be used


ncurses_wrefresh($fullscreen);

$pressed = ncurses_getch();// wait for a user keypress

ncurses_end();// clean up our screen

?>
