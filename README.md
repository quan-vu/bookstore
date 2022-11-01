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
- Put your code on Github or Gitlab.
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

## Quickstart

comming soon ...