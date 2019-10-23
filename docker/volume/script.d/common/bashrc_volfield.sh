# ~/.bashrc: executed by bash(1) for non-login shells.
# see /usr/share/doc/bash/examples/startup-files (in the package bash-doc)
# for examples

# If not running interactively, don't do anything
case $- in
    *i*) ;;
      *) return;;
esac

# don't put duplicate lines or lines starting with space in the history.
# See bash(1) for more options
HISTCONTROL=ignoreboth

# append to the history file, don't overwrite it
shopt -s histappend

# for setting history length see HISTSIZE and HISTFILESIZE in bash(1)
HISTSIZE=1000
HISTFILESIZE=2000

# check the window size after each command and, if necessary,
# update the values of LINES and COLUMNS.
shopt -s checkwinsize

# If set, the pattern "**" used in a pathname expansion context will
# match all files and zero or more directories and subdirectories.
#shopt -s globstar

# make less more friendly for non-text input files, see lesspipe(1)
#[ -x /usr/bin/lesspipe ] && eval "$(SHELL=/bin/sh lesspipe)"

# set variable identifying the chroot you work in (used in the prompt below)
if [ -z "${debian_chroot:-}" ] && [ -r /etc/debian_chroot ]; then
    debian_chroot=$(cat /etc/debian_chroot)
fi

# set a fancy prompt (non-color, unless we know we "want" color)
case "$TERM" in
    xterm-color) color_prompt=yes;;
esac

# uncomment for a colored prompt, if the terminal has the capability; turned
# off by default to not distract the user: the focus in a terminal window
# should be on the output of commands, not on the prompt
#force_color_prompt=yes

if [ -n "$force_color_prompt" ]; then
    if [ -x /usr/bin/tput ] && tput setaf 1 >&/dev/null; then
	# We have color support; assume it's compliant with Ecma-48
	# (ISO/IEC-6429). (Lack of such support is extremely rare, and such
	# a case would tend to support setf rather than setaf.)
	color_prompt=yes
    else
	color_prompt=
    fi
fi

if [ "$color_prompt" = yes ]; then
    PS1='${debian_chroot:+($debian_chroot)}\[\033[01;32m\]\u@\h\[\033[00m\]:\[\033[01;34m\]\w\[\033[00m\]\$ '
else
    PS1='${debian_chroot:+($debian_chroot)}\u@\h:\w\$ '
fi
unset color_prompt force_color_prompt

# If this is an xterm set the title to user@host:dir
case "$TERM" in
xterm*|rxvt*)
    PS1="\[\e]0;${debian_chroot:+($debian_chroot)}\u@\h: \w\a\]$PS1"
    ;;
*)
    ;;
esac

# enable color support of ls and also add handy aliases
if [ -x /usr/bin/dircolors ]; then
    test -r ~/.dircolors && eval "$(dircolors -b ~/.dircolors)" || eval "$(dircolors -b)"
    alias ls='ls --color=auto'
    #alias dir='dir --color=auto'
    #alias vdir='vdir --color=auto'

    #alias grep='grep --color=auto'
    #alias fgrep='fgrep --color=auto'
    #alias egrep='egrep --color=auto'
fi

# colored GCC warnings and errors
#export GCC_COLORS='error=01;31:warning=01;35:note=01;36:caret=01;32:locus=01:quote=01'

# some more ls aliases
#alias ll='ls -l'
#alias la='ls -A'
#alias l='ls -CF'

# Alias definitions.
# You may want to put all your additions into a separate file like
# ~/.bash_aliases, instead of adding them here directly.
# See /usr/share/doc/bash-doc/examples in the bash-doc package.

if [ -f ~/.bash_aliases ]; then
    . ~/.bash_aliases
fi

# enable programmable completion features (you don't need to enable
# this, if it's already enabled in /etc/bash.bashrc and /etc/profile
# sources /etc/bash.bashrc).
if ! shopt -oq posix; then
  if [ -f /usr/share/bash-completion/bash_completion ]; then
    . /usr/share/bash-completion/bash_completion
  elif [ -f /etc/bash_completion ]; then
    . /etc/bash_completion
  fi
fi


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


export LS_OPTIONS='--color=auto'
alias grep='grep --color=auto'
alias ls='ls $LS_OPTIONS'
alias ll='ls $LS_OPTIONS -ali'
alias l='ls $LS_OPTIONS -lA'


alias sf="php bin/console"
alias check_php="which php; whereis php; php --ini;"
alias dump:autoload="composer dump-autoload"
alias cache:clear="php bin/console cache:clear"
alias debug:router="php bin/console debug:router"
alias debug:autowiring="php bin/console debug:autowiring"
alias change-password="php bin/console fos:user:change-password"
alias create:user="php bin/console fos:user:create"
alias user:promote="php bin/console fos:user:promote"
alias dsud="php bin/console d:s:u --dump-sql"
alias dsuf="php bin/console d:s:u --force"
alias fixture:load="php bin/console doctrine:fixtures:load"
alias d:m:d="php bin/console doctrine:migrations:diff"
alias d:m:m="php bin/console doctrine:migrations:migrate"
alias d:d:c="php bin/console doctrine:database:create"
alias d:d:d="php bin/console doctrine:database:drop --force"
alias do:migration="d:d:d; d:d:c; d:m:m; fixture:load;"