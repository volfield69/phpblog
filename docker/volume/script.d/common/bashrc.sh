#!/bin/bash

echo_step "Setting .bashrc"
echo "export LS_OPTIONS='--color=auto'" > /root/.bashrc
echo "alias grep='grep --color=auto'" >> /root/.bashrc
echo "alias ls='ls \$LS_OPTIONS'" >> /root/.bashrc
echo "alias ll='ls \$LS_OPTIONS -l'" >> /root/.bashrc
echo "alias l='ls \$LS_OPTIONS -lA'" >> /root/.bashrc
echo -e "\n" >> /root/.bashrc

echo_step "End Setting .bashrc"
