CREATE TABLE IF NOT EXISTS category (
  pk int(11) NOT NULL auto_increment,
  name varchar(150) NOT NULL default '',
  active char(1) NOT NULL default '1',
  PRIMARY KEY  (pk),
  UNIQUE KEY name (name)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1167 ;


CREATE TABLE IF NOT EXISTS job (
  pk int(11) NOT NULL auto_increment,
  title varchar(150) NOT NULL default '',
  description text NOT NULL,
  status char(1) NOT NULL default 'O',
  salary varchar(30) NOT NULL default 'NA',
  measure char(1) NOT NULL default 'O',
  viewed int(11) NOT NULL default '0',
  applied int(11) NOT NULL default '0',
  marked int(11) NOT NULL default '0',
  inserted date NOT NULL default '0000-00-00',
  active char(1) NOT NULL default '1',
  fk_category text NOT NULL,
  fk_location text NOT NULL,
  fk_user int(11) NOT NULL default '0',
  PRIMARY KEY  (pk)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=140 ;


CREATE TABLE IF NOT EXISTS location (
  pk int(11) NOT NULL auto_increment,
  name varchar(150) NOT NULL default '',
  active char(1) NOT NULL default '1',
  PRIMARY KEY  (pk),
  UNIQUE KEY name (name)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1264 ;


CREATE TABLE IF NOT EXISTS search (
  pk int(11) NOT NULL auto_increment,
  ip varchar(25) NOT NULL default '',
  keyword varchar(250) default NULL,
  total int(11) NOT NULL default '0',
  searched date NOT NULL default '0000-00-00',
  fk_category text NOT NULL,
  fk_job text NOT NULL,
  fk_location text NOT NULL,
  PRIMARY KEY  (pk),
  KEY keyword (keyword)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;


CREATE TABLE IF NOT EXISTS user (
  pk int(11) NOT NULL auto_increment,
  email varchar(50) NOT NULL default '',
  password varchar(25) NOT NULL default '',
  registered date NOT NULL default '0000-00-00',
  last_login date NOT NULL default '0000-00-00',
  active char(1) NOT NULL default '0',
  PRIMARY KEY  (pk),
  UNIQUE KEY email (email)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=335 ;
