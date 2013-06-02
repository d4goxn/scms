# Architecture

SCMS follows an MVC architecture with request routing.

The model is a MySQL database, which is routinely dumped to `./scms.sql` and versioned with the rest of the project. Anyone using the project is advised to create a database named after their project and import `.scms.sql`, then export it to a different SQL file. The user's database dump should not be under version control if it contains unencrypted sensitive information. See `./INSTALL.md` for details.

Views are rendered on the client from JSON data, using AngularJS templates. AJAX requests are handled by jQuery. Layout logic and styling is handled by Twitter Bootstrap. Transitions and effects use CSS3, but styling will be kept to a functional minimum, because SCMS users are likely to replace it.

The controllers are in `./controllers/`. All view code runs client side. There is also a view controller on the client side, which is responsible for keeping the view in sync with the model and handling preliminary validation on form input.

Request handlers are in `./request-handlers`. Their job is to parse incoming requests and invoke the appropriate controllers, and then return a response to the client.

## Testing

Tests are written before features are implemented, then refined as need. Testing focuses on the HTTP interface using curl to make requests. Some fine grain testing will also be needed for individual controllers.

## Client - Server Interface

The server exposes its functionality to the client through a RESTful HTTP interface. Client views are interchangeable, as far as the server is concerned. For exploring the HTTP interface interactively, I recommend using the [Postman](http://www.getpostman.com/) addon for Chromium / Google Chrome.

### HEAD /<entity-name>

Returns a basic HTTP header describing the entity.

### GET /

Retrieves the main view, which loads the view controller code. What happens next depends on the view itself: it could show an ultra minimalist page with a few links to other parts of the site, or it could start pulling in sorted, filtered content like a news site, or anything in between.

### GET /<entity-name>

Retrieves a single entity by its unique name. `Content-Type` will be `text/json`, which the client will be expected to render.

### HEAD /search?<parameters>

Returns an HTTP response header that includes a non-standard `X-Result-Count` field containing the number of search results.

### GET /search?<parameters>

Returns a JSON array of a page of search results. The page is specified by its length and page number. If no search parameters are given, then all entities are listed.

#### Parameters

 - `page-length`: Results per page.
 - `page`: Page number.
 - `contains-tags`: Tag list.
 - `excludes-tags`: Tag list.
 - `title-contains-text`: Search string.
 - `title-contains-text`: Search string.
 - `body-excludes-text`: Search string.
 - `body-excludes-text`: Search string.
 - `created-before`: Unix timestamp.
 - `created-after`: Unix timestamp.
 - `last-modified-before`: Unix timestamp.
 - `last-modified-after`: Unix timestamp.
 - `order-fields`: List of fields used for sorting.
 - `order-directions`: List of `ASC` / `DESC` fields corresponding to `order-fields`.
