`id` integer auto_increment,
`name` varchar(50) NOT NULL,
`aka` varchar(40) DEFAULT NULL,
`type` varchar(30) NOT NULL,
`clan` varchar(30) NOT NULL,
`banned` varchar(10) DEFAULT NULL,
`artist` varchar(40) DEFAULT NULL,
`capacity` varchar(10) NOT NULL,
`disciplines` varchar(30) DEFAULT NULL,
`set` varchar(60) DEFAULT NULL,
`card_text` varchar(300) NOT NULL,

`adv` varchar(10) DEFAULT NULL,
`group` varchar(10) NOT NULL,
`title` varchar(20) DEFAULT NULL,

`pool_cost` varchar(10) DEFAULT NULL,
`blood_cost` varchar(10) DEFAULT NULL,
`conviction_cost` varchar(20) DEFAULT NULL,
`burn_option` varchar(20) DEFAULT NULL,
`flavor_text` varchar(280) DEFAULT NULL,