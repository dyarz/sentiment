SELECT tweet_text FROM datalatih LIMIT 10

SELECT COUNT(*) FROM n_gram WHERE n_gram LIKE "_s" AND sentiment="positif"

CREATE TABLE `n_gram` (
  `kd_ngram` INT(3) NOT NULL AUTO_INCREMENT,
  `n_gram` VARCHAR(3) NOT NULL,
  `sentiment` VARCHAR(10) DEFAULT NULL,
  `frekuensi` FLOAT DEFAULT NULL,
  `probabilitas` FLOAT DEFAULT NULL,
  PRIMARY KEY (`kd_ngram`)
) ENGINE=INNODB DEFAULT CHARSET=latin1