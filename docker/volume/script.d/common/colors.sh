#!/bin/bash

##### Colors
black='\e[0;30m'
grey='\e[1;30m'
darkRed='\e[0;31m'
BoldRed='\e[0;31m'
pink='\e[1;31m'
darkGreen='\e[0;32m'
lightGreen='\e[1;32m'
orange='\e[0;33m'
yellow='\e[1;33m'
darkBlue='\e[0;34m'
lightBlue='\e[1;34m'
darkPurple='\e[0;35m'
lightPurple='\e[1;35m'
darkCyan='\e[0;36m'
lightcyan='\e[1;36m'
lightGrey='\e[0;37m'
white='\e[1;37m'

none='\e[0;m'
##### \Colors

##### Display Function
function echo_title() {
    echo -e "${lightBlue}****************************************************${none}"
    echo -e "${lightBlue}          $1${none}"
    echo -e "${lightBlue}****************************************************${none}"
}

function echo_step() {
    echo -e "${lightGreen} \n$1 ${none}"
}

function color() {
    set -o pipefail
    ("$@" 2>&1>&3 | sed $'s,.*,\e[01;31m&\e[m,'>&2) 3>&1
}
##### \Display Function