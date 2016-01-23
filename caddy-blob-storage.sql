create table Caddy (
	id_caddy bigint unsigned not null auto_increment,
	date_creation datetime not null,
	date_update datetime null,
	blob_caddy text not null,
	primary key( id_caddy )
);