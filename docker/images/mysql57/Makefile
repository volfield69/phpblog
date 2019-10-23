SHELL=/bin/bash
NAME=phpblog/mysql57
VERSION=0.1.0

all: build tag_latest

build:
	docker build -t $(NAME):$(VERSION) .
	
tag_latest:
	docker tag $(NAME):$(VERSION) $(NAME):latest
