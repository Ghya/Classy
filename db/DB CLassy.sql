-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mar 22 Août 2017 à 19:43
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `classy`
--

-- --------------------------------------------------------

--
-- Structure de la table `chapter`
--

CREATE TABLE `chapter` (
  `chap_id` int(11) NOT NULL,
  `chap_name` varchar(255) NOT NULL,
  `chap_sub_id` int(11) NOT NULL,
  `chap_class_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `chapter`
--

INSERT INTO `chapter` (`chap_id`, `chap_name`, `chap_sub_id`, `chap_class_id`) VALUES
(1, 'Les feutres', 1, 1),
(2, 'Les Nombres', 2, 2),
(3, 'Les formes', 3, 1),
(4, 'Les Couleurs', 4, 1),
(5, 'Les animaux', 4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `class`
--

CREATE TABLE `class` (
  `class_id` int(10) NOT NULL,
  `class_lvl` varchar(255) NOT NULL,
  `class_etab` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `class`
--

INSERT INTO `class` (`class_id`, `class_lvl`, `class_etab`) VALUES
(1, 'Maternelle', 'Strasbourg 1'),
(2, 'CE1', 'Strasbourg 2'),
(3, 'CE2', 'Strasbourg 3');

-- --------------------------------------------------------

--
-- Structure de la table `c_mark`
--

CREATE TABLE `c_mark` (
  `c_mark_id` int(11) NOT NULL,
  `c_mark_value` int(11) NOT NULL,
  `c_mark_stud_id` int(11) NOT NULL,
  `c_mark_test_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `c_test`
--

CREATE TABLE `c_test` (
  `c_test_id` int(11) NOT NULL,
  `c_test_name` varchar(255) NOT NULL,
  `c_test_chap_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `lesson`
--

CREATE TABLE `lesson` (
  `less_id` int(11) NOT NULL,
  `less_title` varchar(255) NOT NULL,
  `less_situation` varchar(255) NOT NULL,
  `less_goal` text NOT NULL,
  `less_equipment` text NOT NULL,
  `less_skill` text NOT NULL,
  `less_time` varchar(255) NOT NULL,
  `less_chap_id` int(11) NOT NULL,
  `less_class_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `lesson`
--

INSERT INTO `lesson` (`less_id`, `less_title`, `less_situation`, `less_goal`, `less_equipment`, `less_skill`, `less_time`, `less_chap_id`, `less_class_id`) VALUES
(1, 'Apprendre à utiliser un feutre', 'Début de parcours', 'L\'éléve doit réussir à colorier avec un feutre', 'Des feutres', 'Colorier une image', '1h', 1, 1),
(2, 'La Multiplication', 'Début de parcours', 'Comprendre la multiplication', 'Calculette', 'Faire une simple multiplication', '1h', 2, 2),
(3, 'La forme ronde', 'Début de parcours', 'Dessiner une forme ronde', 'feuilles, crayons', 'Tracer un rond', '50min', 3, 1),
(5, 'l\'autruche', 'l', 'l', 'l', 'l', 'l', 5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `l_mark`
--

CREATE TABLE `l_mark` (
  `l_mark_id` int(11) NOT NULL,
  `l_mark_value` int(11) NOT NULL,
  `l_mark_stud_id` int(11) NOT NULL,
  `l_mark_test_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `l_mark`
--

INSERT INTO `l_mark` (`l_mark_id`, `l_mark_value`, `l_mark_stud_id`, `l_mark_test_id`) VALUES
(196, 13, 3, 31),
(195, 16, 5, 31),
(194, 14, 7, 31),
(193, 12, 4, 31),
(192, 15, 2, 31),
(191, 12, 1, 31),
(190, 10, 6, 31),
(189, 16, 3, 30),
(188, 15, 5, 30),
(187, 14, 7, 30),
(186, 13, 4, 30),
(185, 12, 2, 30),
(184, 11, 1, 30),
(183, 10, 6, 30),
(182, 16, 3, 29),
(181, 15, 5, 29),
(180, 14, 7, 29),
(179, 13, 4, 29),
(178, 12, 2, 29),
(177, 11, 1, 29),
(176, 10, 6, 29);

-- --------------------------------------------------------

--
-- Structure de la table `l_test`
--

CREATE TABLE `l_test` (
  `l_test_id` int(11) NOT NULL,
  `l_test_name` varchar(255) NOT NULL,
  `l_test_less_id` int(11) NOT NULL,
  `l_test_class_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `l_test`
--

INSERT INTO `l_test` (`l_test_id`, `l_test_name`, `l_test_less_id`, `l_test_class_id`) VALUES
(31, 'test autre eval', 3, 1),
(30, 'final test note', 5, 1),
(29, 'final test note', 5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `memo`
--

CREATE TABLE `memo` (
  `memo_id` int(11) NOT NULL,
  `memo_title` varchar(255) NOT NULL,
  `memo_content` text NOT NULL,
  `memo_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `memo`
--

INSERT INTO `memo` (`memo_id`, `memo_title`, `memo_content`, `memo_date`) VALUES
(253, 'Test', 'je suis un mémo', '2017-08-18');

-- --------------------------------------------------------

--
-- Structure de la table `step`
--

CREATE TABLE `step` (
  `step_id` int(11) NOT NULL,
  `step_name` varchar(255) NOT NULL,
  `step_content` text NOT NULL,
  `step_time` varchar(255) NOT NULL,
  `step_less_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `step`
--

INSERT INTO `step` (`step_id`, `step_name`, `step_content`, `step_time`, `step_less_id`) VALUES
(2, 'Enlever le capuchons', 'L\'élève qui n\'est pas teubé comprendra qu\'il faut commencer par enlever le capuchon', '1min', 1),
(3, 'colorier', 'il faut utiliser le bout coloré', '10min', 1),
(4, 'Ne pas dépasser', 'Il faut reussir a rester dans le dessin', '10min', 1),
(8, 'Multiplier 2 Chiffres', 'Commencer à apprendre à l\'élève comment multiplier 2 chiffres ensemble', '10min', 2),
(9, 'Préparer le matériel', 'Préparer sa feuille et son crayon', '5min', 3),
(10, 'Tenir correctement le crayon', 'Apprendre à l\'élève à tenir un crayon', '5min', 3),
(11, 'Dessiner', 'L\'élève dessine', '40min', 3),
(12, 'voir une autrucche', 'hghjgghjhjlghjl', '10min', 5),
(13, 'tuer l\'autruche', 'hjhjhmjhmkj', '10min', 5);

-- --------------------------------------------------------

--
-- Structure de la table `student`
--

CREATE TABLE `student` (
  `stud_id` int(11) NOT NULL,
  `stud_firstname` varchar(255) NOT NULL,
  `stud_name` varchar(255) NOT NULL,
  `stud_class_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `student`
--

INSERT INTO `student` (`stud_id`, `stud_firstname`, `stud_name`, `stud_class_id`) VALUES
(1, 'John', 'Attend', 1),
(2, 'Jean', 'Bon', 1),
(3, 'Sophie', 'Stiqué', 1),
(4, 'Harry', 'Covert', 1),
(5, 'Pierre', 'Poljak', 1),
(6, 'Anne', 'Aconda', 1),
(7, 'John', 'Deuf', 1);

-- --------------------------------------------------------

--
-- Structure de la table `subject`
--

CREATE TABLE `subject` (
  `sub_id` int(11) NOT NULL,
  `sub_name` varchar(255) NOT NULL,
  `sub_class_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `subject`
--

INSERT INTO `subject` (`sub_id`, `sub_name`, `sub_class_id`) VALUES
(1, 'Coloriage', 1),
(2, 'Math', 2),
(3, 'Dessin', 1),
(4, 'Découvrire le monde', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_salt` varchar(255) NOT NULL,
  `user_role` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_pass`, `user_salt`, `user_role`) VALUES
(1, 'Ghya', '$2y$13$NMEfaUmKoYiW7TfhxU/hUucetHKpyFr1/eHxwt45UIfQAZtHtrV3O', 'dhMTBkzwDKxnD;4KNs,4ENy', 'ROLE_ADMIN'),
(2, 'test', '$2y$13$MNMsvnMb55QIDJa/SjUM0eRVDwXRvXlFBzV/8Alhn5j6Wgv0K003S', '8b030c9529450fe4b9f6c7e', 'ROLE_USER'),
(4, 'tam', '$2y$13$fHPewwe4oQJDmpSOoAXTl.kX1n2.n6PrZCWtAtbdUCPIHnnWs6Ovm', '7a51201dedb1612edd1e8df', 'ROLE_USER');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `chapter`
--
ALTER TABLE `chapter`
  ADD PRIMARY KEY (`chap_id`);

--
-- Index pour la table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Index pour la table `c_mark`
--
ALTER TABLE `c_mark`
  ADD PRIMARY KEY (`c_mark_id`);

--
-- Index pour la table `c_test`
--
ALTER TABLE `c_test`
  ADD PRIMARY KEY (`c_test_id`);

--
-- Index pour la table `lesson`
--
ALTER TABLE `lesson`
  ADD PRIMARY KEY (`less_id`);

--
-- Index pour la table `l_mark`
--
ALTER TABLE `l_mark`
  ADD PRIMARY KEY (`l_mark_id`);

--
-- Index pour la table `l_test`
--
ALTER TABLE `l_test`
  ADD PRIMARY KEY (`l_test_id`);

--
-- Index pour la table `memo`
--
ALTER TABLE `memo`
  ADD PRIMARY KEY (`memo_id`);

--
-- Index pour la table `step`
--
ALTER TABLE `step`
  ADD PRIMARY KEY (`step_id`);

--
-- Index pour la table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`stud_id`);

--
-- Index pour la table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`sub_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `chapter`
--
ALTER TABLE `chapter`
  MODIFY `chap_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `c_mark`
--
ALTER TABLE `c_mark`
  MODIFY `c_mark_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `c_test`
--
ALTER TABLE `c_test`
  MODIFY `c_test_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `lesson`
--
ALTER TABLE `lesson`
  MODIFY `less_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `l_mark`
--
ALTER TABLE `l_mark`
  MODIFY `l_mark_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;
--
-- AUTO_INCREMENT pour la table `l_test`
--
ALTER TABLE `l_test`
  MODIFY `l_test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT pour la table `memo`
--
ALTER TABLE `memo`
  MODIFY `memo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;
--
-- AUTO_INCREMENT pour la table `step`
--
ALTER TABLE `step`
  MODIFY `step_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `student`
--
ALTER TABLE `student`
  MODIFY `stud_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `subject`
--
ALTER TABLE `subject`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
