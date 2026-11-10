# Du lieu mock va luong MVC

## Luong du lieu

routes/web.php injects Repositories into Controllers. Controllers pass explicit data to render(). Views use foreach and shared components; they do not load fixtures, call Repositories, or inspect REQUEST_URI to choose a product type.

## Fixtures

- products.php: 11 canonical products with integer VND prices, image galleries, wine/gift type, demo availability and legacy slug aliases. Duplicate Penfolds cards share a record; primary catalog data wins when related cards disagree.
- categories.php: 43 existing category paths, descriptions, parents, product references and navigation. The main demo collection keeps 9 cards; the gift collection keeps 3. Existing legacy categories still share demo collections; these are not verified real inventory classifications.
- brands.php: 16 brand gallery records.
- home.php: 5 hero slides, 4 price slides, 3 regional tabs, collection banners, CountUp statistics and homepage copy.
- catalog.php: demo filter options/counts, related product order and price disclaimer.
- product_detail.php: shared summary, specifications, description, FAQs and benefits extracted from the old template. These remain Phase 1 placeholders, including old whisky content. specifications_verified=false and product.detail_status=placeholder flag the need for verified wine/gift content before production.
- articles.php: 11 article cards, their images, dates and article categories. Existing detail URLs render title/image and an explicit unfinished-content notice; no article body is invented.
- site.php: shared desktop/mobile menus and menu contact information.
- presentation.php: existing IDs and visual settings retained for CSS/Flickity compatibility. This is presentation metadata, not a proposed database schema.

Fixtures contain structured data, not copied card markup. SVG icons, HTML and CSS remain in View components. Fixed about/founder editorial content and interface labels remain in their Views.

## Repositories

FixtureRepository validates and caches array fixtures per instance. The fixture directory is injectable for isolated tests.

ProductRepository: all, findBySlug, findMany, forCategory.
CategoryRepository: all, findBySlug, overview, navigation.
BrandRepository, HomeRepository, CatalogRepository, SiteRepository and ArticleRepository serve their corresponding collections.

Broken product references fail explicitly. Unknown products and invalid full category paths return 404. Legacy aliases resolve to canonical records. A gift query parameter cannot switch templates. Name, price, image and product type come from the selected product; descriptions/specifications remain the shared placeholders described above.

## Database follow-up

Replace fixture reads inside Repositories with database queries while retaining the Controller/View data contract. Confirm schema, category membership and verified product descriptions first. No database connection, queries or migrations have been introduced. Product search, filtering and pagination remain demo behavior. Article fixture pagination uses 3 items per page.

## Tests

Run:

```sh
php tests/core.php
php tests/fixtures.php
```

Fixture tests cover numeric prices, image existence, aliases, all category references, missing records, query-independent gift behavior, and injected fixture changes reflected in escaped listing/detail output.

home.js now guards missing elements and skips Flickity-managed sliders. Toastr loaders are removed. Existing frontend-script.js guards and legacy WordPress integrations remain separate follow-up items. Hero and price sliders use the restored Flatsome chunks.
