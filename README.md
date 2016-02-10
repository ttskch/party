# nagoyaphp-party

Calculate amounts of pizzas and drinks.

## Installation

```bash
$ git clone git@github.com:qckanemoto/nagoyaphp-party.git
$ cd nagoyaphp-party
$ cp config/config.php.placeholder config/config.php # and tailor config.php if you need
$ composer install
$ ln -s $(pwd)/nagoya /usr/local/bin/nagoya
```

## Usage

```bash
$ nagoya party
How many people? : 9
How many people will drink beer? : 6
How many people will drink non-alcohol? : 2
+-------------------------------+-----+-------+
|                               | Num | Price |
+-------------------------------+-----+-------+
| Pizza (L)                     | 4   | 12000 |
| Cans of beer                  | 15  | 3450  |
| Cans of other alcohol         | 3   | 690   |
| Bottles of non-alcohol (1.5L) | 2   | 400   |
+-------------------------------+-----+-------+
| Total                         | -   | 16540 |
| Average                       | -   | 1838  |
+-------------------------------+-----+-------+
```
