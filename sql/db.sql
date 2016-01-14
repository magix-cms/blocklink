--
-- Structure de la table `mc_plugins_blocklink`
--

CREATE TABLE IF NOT EXISTS `mc_plugins_blocklink` (
  `idlink` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `idlang` smallint(3) unsigned NOT NULL DEFAULT '1',
  `title` varchar(130) NOT NULL,
  `content` varchar(200) DEFAULT NULL,
  `url` varchar(200) NOT NULL,
  `blank` smallint(1) NOT NULL DEFAULT '0',
  `ltype` enum('cms','cat','custom') NOT NULL DEFAULT 'custom',
  `lorder` smallint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`idlink`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;