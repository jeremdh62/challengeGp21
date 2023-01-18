# Challenge Groupe 21

## Installation

```bash 
$ docker compose up -d
```
Install the dependencies in front and back in the container docker

### Back 
```bash
$ docker compose exec back /bin/sh
$ cd html
$ composer install
$ php bin/console lexik:jwt:generate-keypair
```

### Front
```bash
$ docker compose exec front /bin/sh
$ npm install
$ npm run dev
```

## Usage

### Run Front
```bash
$ npm run dev
```