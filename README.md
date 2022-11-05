# Book Store

A book marketplace which has millions of books from publishers worldwide. 

## Features

### Search Books

Requirements

- Search API for end-users can find books in less than a seconds.
- The system should have a single api endpoint like http://someflousrishingcompany.com/search/book?q={keyword}
- The `keyword` can be a `title,` `summary,` `publisher,` or `authors.`
- The final JSON data model for a response should contain these values:

- The project should have units and integrations tests.
- Dockerize your project and make sure that it will work out of the box.
- Catch all edge cases and aim for the best run-time possible.
- You are free to use any architecture, design, and implementation method, but not external on-premise or cloud services.

Example Response:

```json
[
    {
        "id": 1234,
        "publisher": "Packt",
        "title": "Mastering Something",
        "summary": "some long summary",
        "authors": [
            "Author One",
            "Author Two"
        ]
    }
]
```

Example Database:

- books: 4.935.193 unique records
- authors: 936.971 unique records
- publishers: 900.000 unique records



## Quickstart

Easy to set up project run this command:

```shell
make init
```

> After the project was initialized successfully, we need to import sample database with over 4 million unique books
> Download sample database here: https://drive.google.com/drive/folders/1IElimDKEKbC90bUbOJE6O1dIToS87E6v?usp=sharing
> To import to database I recommend to use MySQL Workbench.

Index all books to ElasticSearch:

```shell
make elastic-index-all-books
```

Run Tests

```shell
make test
```

## Documentation

We use Postman for create API Docs, let check this file:

- BookStore.postman_collection.json
- BookStore - Local.postman_environment.json

## Useful Commands

Start project

```shell
make up
```

Stop project

```shell
make down
```

Clean project and all data, docker container

```shell
make clean
```

Run tests

```shell
make test
```

## Reference 

- PHP ElasticSearch 8.5.0: https://packagist.org/packages/elasticsearch/elasticsearch
- Kibana 8.5.0: https://www.elastic.co/guide/en/kibana/8.5/docker.html


