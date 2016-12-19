# bm-stats

Collects Brandmeister call length statistics to a MySQL table.

The SQL table structure can be found in *example.sql*. Talk time is stored in seconds
for each day for every DMR ID.

## Usage

- You'll need PHP CLI (ex. php5-cli) and [phpMQTT](https://github.com/bluerhinos/phpMQTT).
- Rename (and edit) *config-example.inc.php* to *config.inc.php*.

### Running as a daemon

It's not ideal to run command line PHP scripts as daemons, but I had most of
the routines used here in other projects, so I wrote this in PHP. Feel free
to rewrite this to a better language.
