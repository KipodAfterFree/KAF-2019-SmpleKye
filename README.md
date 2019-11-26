# SmpleKye

SmpleKye is an information security challenge in the Web category, and was presented to participants of [KAF CTF 2019](https://ctf.kipodafterfree.com)

## Challenge story

No story

## Challenge exploit

Basic POW (Bruteforcing hashes)

## Challenge solution

```php
<?php

const LEN = 7;

$to = "00";

r($to);

function r($to){
	foreach(str_split("01234567890abcdef") as $c){
		if(strlen($to) === LEN - 1){
			if(strpos(hash("sha256", $to . $c), $to . $c) !== false)
				echo $to . $c . "\n";
		}else{
			r($to . $c);
		}
	}
}
```

## Building and installing

[Clone](https://github.com/NadavTasher/2019-SmpleKye/archive/master.zip) the repository, then type the following command to build the container:
```bash
docker build . -t smplekye
```

To run the challenge, execute the following command:
```bash
docker run --rm -d -p 1080:80 smplekye
```

## Usage

You may now access the challenge interface through your browser: `http://localhost:1080`

## Flag

Flag is:
```flagscript
KAF{ju57_4_51mpl3_pr00F_0F_w0Rk}
```

## License
[MIT License](https://choosealicense.com/licenses/mit/)