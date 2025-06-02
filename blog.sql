create TABLE post (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    content TEXT(65000) NOT NULL,
    created_at  DATETIME  NOT NULL,
    PRIMARY KEY (id)
)

CREATE table category (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
)

create table post_category (
    post_id int UNSIGNED not null,
    category_id int UNSIGNED not null,
    PRIMARY KEY (post_id,category_id),
    constraint fk_post
        FOREIGN KEY (post_id)
        REFERENCES post (id)
        on delete cascade
        on update restrict,
    constraint fk_category
        FOREIGN KEY (category_id)
        REFERENCES category (id)
        on delete cascade
        on update restrict
)

create table user (
    id int unsigned not null AUTO_INCREMENT,
    username VARCHAR(255) not null,
    password varchar(255) not null,
    PRIMARY key (id)
)
