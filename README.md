<p align="center">
  <a href="https://codely.com">
    <img alt="Codely logo" src="https://user-images.githubusercontent.com/10558907/170513882-a09eee57-7765-4ca4-b2dd-3c2e061fdad0.png" width="300px" height="92px"/>
  </a>
</p>

<p align="center">Template to start from scratch a new Php project using DDD as architecture.</p>

## Installation

Use the dependency manager [Composer](https://getcomposer.org/) to create a new project.

```
composer create-project codelytv/ddd-skeleton
```

## Usage with Docker

Just run:

```
make build
```

Then go to `http://localhost:8030/health-check` to check all is ok.

## Usage from local

First of all you should execute 

```
make prepare-local
```

And then start local environment:

```
make start-local
```

And then going to `http://localhost:8030/health-check` to check all is ok.

## Contributing
There are some things missing feel free to add this if you want! If you want
some guidelines feel free to contact us :)
