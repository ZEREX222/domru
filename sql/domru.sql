/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50532
Source Host           : localhost:3306
Source Database       : domru

Target Server Type    : MYSQL
Target Server Version : 50532
File Encoding         : 65001

Date: 2015-08-23 18:19:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `channel`
-- ----------------------------
DROP TABLE IF EXISTS `channel`;
CREATE TABLE `channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) CHARACTER SET utf8 DEFAULT NULL,
  `epg_channel_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of channel
-- ----------------------------
INSERT INTO `channel` VALUES ('1', 'VH1 European', '513');
INSERT INTO `channel` VALUES ('2', 'ZeeTV', '514');
INSERT INTO `channel` VALUES ('3', 'Russia today Doc HD', '1025');
INSERT INTO `channel` VALUES ('4', 'Карусель', '523');
INSERT INTO `channel` VALUES ('5', 'Nickelodeon HD', '533');

-- ----------------------------
-- Table structure for `schedule`
-- ----------------------------
DROP TABLE IF EXISTS `schedule`;
CREATE TABLE `schedule` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `channel_id` int(11) DEFAULT NULL,
  `title` varchar(256) CHARACTER SET utf8 DEFAULT NULL,
  `is_catchup_available` bit(1) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `start` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_CHANNEL_ID_CHANNEL_ID` (`channel_id`),
  CONSTRAINT `FK_CHANNEL_ID_CHANNEL_ID` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of schedule
-- ----------------------------
INSERT INTO `schedule` VALUES ('1', '1', 'Keep Calm & Wind Down', '', '7200', '2015-08-24 09:30:45');
INSERT INTO `schedule` VALUES ('2', '1', 'Late Night Love', '', '3600', '2015-08-24 09:31:00');
INSERT INTO `schedule` VALUES ('3', '1', 'Vh1 Shuffle', '', '21600', '2015-08-24 09:31:42');
INSERT INTO `schedule` VALUES ('4', '2', 'На грани! [12+]', '', '3600', '2015-08-24 09:32:16');
INSERT INTO `schedule` VALUES ('5', '2', 'Хочу танцевать! [12+]', '', '1800', '2015-08-24 09:30:43');
INSERT INTO `schedule` VALUES ('6', '2', 'Вторая свадьба [12+]', '', '1800', '2015-08-24 09:33:05');
INSERT INTO `schedule` VALUES ('7', '3', 'Балканский излом [16+]', '', '1800', '2015-08-25 09:40:27');
INSERT INTO `schedule` VALUES ('8', '3', 'Чукотская сенсация [16+]', '', '1800', '2015-08-25 09:33:43');
INSERT INTO `schedule` VALUES ('9', '3', 'Интервью с моей мамой [16+]', '', '1800', '2015-08-25 09:34:04');
INSERT INTO `schedule` VALUES ('10', '5', 'Аватар [6+] - 50-я серия', '', '1500', '2015-08-25 09:35:21');
INSERT INTO `schedule` VALUES ('11', '5', 'Биг Тайм Раш [12+] - 7-я серия', '', '1500', '2015-08-25 09:35:24');
INSERT INTO `schedule` VALUES ('12', '5', 'Биг Тайм Раш [12+] - 8-я серия', '', '1500', '2015-08-25 09:35:31');
INSERT INTO `schedule` VALUES ('13', '4', 'Большие буквы', '', '1800', '2015-08-25 18:35:43');
INSERT INTO `schedule` VALUES ('14', '4', 'Однажды в деревне', '', '1200', '2015-08-25 09:36:02');
INSERT INTO `schedule` VALUES ('15', '4', 'Дорожная азбука\"', '', '2400', '2015-08-26 09:36:21');
