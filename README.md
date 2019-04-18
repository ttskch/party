# nagoyaphp-party

Calculate amounts of pizzas and drinks.

## Installation

```bash
$ git clone git@github.com:ttskch/nagoyaphp-party.git
$ cd nagoyaphp-party
$ composer install
$ ln -s $(pwd)/nagoya /usr/local/bin/nagoya
```

## Usage

```bash
$ nagoya party
How many people? : 15
How much is budget per person? : 2000
+-------------------------------+-----+-------+
|                               | Num | Price |
+-------------------------------+-----+-------+
| Pizza (L)                     | 8   | 24000 |
| Cans of beer                  | 17  | 3910  |
| Cans of other alcohol         | 9   | 1800  |
| Bottles of non-alcohol (1.5L) | 2   | 400   |
+-------------------------------+-----+-------+
| Total                         | -   | 30110 |
| Average                       | -   | 2008  |
+-------------------------------+-----+-------+
```
