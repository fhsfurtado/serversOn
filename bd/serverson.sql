CREATE TABLE IF NOT EXISTS tb_users(
    id_user int(4) AUTO_INCREMENT,
    nome_user varchar(100) NOT NULL,
    login_user varchar(30) NOT NULL,
    psw_user varchar(50) NOT NULL,
    data_creation timestamp DEFAULT CURRENT_TIMESTAMP,
    status_user boolean NOT NULL,
    data_inactive timestamp,
    PRIMARY KEY(id_user)
);

CREATE TABLE IF NOT EXISTS tb_internal_servers(
    id_server int(4) AUTO_INCREMENT,
    id_creator int(4) NOT NULL,
    hostname varchar(50) NOT NULL,
    ip_address varchar(20) NOT NULL,
    status_server boolean NOT NULL,
    PRIMARY KEY(id_server),
    FOREIGN KEY(id_creator) REFERENCES tb_users(id_user)
);

CREATE TABLE IF NOT EXISTS tb_ports(
    id_port int(4) AUTO_INCREMENT,
    id_server int(4) NOT NULL,
    port_name varchar(10) NOT NULL,
    port varchar(20) NOT NULL,
    PRIMARY KEY(id_port),
    FOREIGN KEY(id_server) REFERENCES tb_internal_servers(id_server)
);

CREATE TABLE IF NOT EXISTS tb_server_fails(
    id_fail int(4) AUTO_INCREMENT,
    id_server int(4) NOT NULL,
    data_fail timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    data_return timestamp ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY(id_fail),
    FOREIGN KEY (id_server) REFERENCES tb_internal_servers(id_server)
);

CREATE TABLE IF NOT EXISTS tb_reason_fail(
    id_reason int(4) AUTO_INCREMENT,
    id_fail int(4) NOT NULL,
    reason text NOT NULL,
    PRIMARY KEY(id_reason),
    FOREIGN KEY (id_fail) REFERENCES tb_server_fails(id_fail)
);

CREATE TABLE IF NOT EXISTS tb_name_port(
    id_name_port int(2) AUTO_INCREMENT,
    nome_port varchar(10) NOT NULL,
	PRIMARY KEY(id_name_port)
)