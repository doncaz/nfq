Feed data collector
===

Used Design patterns
===
 - Simple Factory (src/AppBundle/Model/Feed/FeedFactory.php)
 - Dependency Injection (src/AppBundle/DependencyInjection)
 - Entity Repository (src/AppBundle/Entity/Repository)
 
Used SPL features
===
 - Array shorder [] (src/AppBundle/Controller/*)
 - Traits (src/AppBundle/Sync/Processor/FeedSyncProcessor.php)
 - Class member access on instantiation (src/AppBundle/Model/Feed/FeedFactory.php)
 
3rd party bundles used
===
 - debril/rss-atom-bundle (https://github.com/alexdebril/rss-atom-bundle) for reading Rss or Atom feeds

Installation
===
To run the project copy content to specific folder, and run composer command:

```sh
$ composer install
```

Command list
===
This command for creating new feed in database:
```sh
$ php app/console rss-feed:create <url> <title> <category>
```

This command for assign new category for existing feed:
```sh
$ php app/console rss-feed:assign-category <url> <category>
```

This command for scan added feed and write all new articles in database (if ```--url``` option is set than just provided feed will be synchronized):
```sh
$ php app/console rss-feed:sync --url
```

This command for remove existing feed from database with all its data:
```sh
$ php app/console rss-feed:remove <url>
```

Routing list
===

Route for view all feeds by category, and its recent articles:

```sh
http://example-host.com/feed/list/<category>
```