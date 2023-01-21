-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21-Jan-2023 às 02:27
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `quark_db`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `IdUnique` varchar(255) NOT NULL,
  `owner` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `chat`
--

INSERT INTO `chat` (`id`, `Name`, `IdUnique`, `owner`) VALUES
(1, 'teste', '1b661f640c9ec6b089b6eabda32c45a5', 1),
(2, 'hjluçbghjklubghkl', '3ae309669fef17fb03b3f1bf90e2e48c', 1),
(3, '44', '1c76c6c038d312f805385bec7a080fbc', 1),
(4, 'bgd', '779aa5703019ba75d88a0d6c824cec81', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `chatconfig`
--

CREATE TABLE `chatconfig` (
  `id` int(11) NOT NULL,
  `chat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `directmessage`
--

CREATE TABLE `directmessage` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `friend` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `directmessage`
--

INSERT INTO `directmessage` (`id`, `user`, `friend`, `message`, `date`) VALUES
(1, 2, 2, 'teste', '2023-01-19 23:33:28'),
(4, 1, 3, 'aaaaaaaaaaa', '2023-01-19 23:59:34'),
(5, 1, 2, 'aa', '2023-01-20 00:04:58'),
(6, 1, 2, 'aaaaa', '2023-01-20 00:05:06'),
(8, 1, 3, 'aaaaa', '2023-01-20 01:11:28'),
(9, 1, 7, 'aa', '2023-01-20 01:14:11'),
(10, 7, 4, 'aaaaaa', '2023-01-20 18:02:58'),
(11, 7, 3, 'aaaaaaaaaaa', '2023-01-20 18:03:10'),
(12, 7, 3, 'aaaaaa', '2023-01-20 18:12:54'),
(13, 7, 3, 'aaaaaaaaaaaaaa', '2023-01-20 18:12:57'),
(14, 7, 3, 'aaaaaaaaaaa', '2023-01-20 18:16:37'),
(15, 7, 3, 'Aaaaaaaaaaaaaaaaa', '2023-01-20 18:41:55'),
(16, 7, 3, 'mjhklç', '2023-01-20 18:53:33'),
(18, 7, 4, '03', '2023-01-20 18:55:03'),
(19, 7, 3, 'a', '2023-01-20 19:44:45'),
(20, 3, 7, 'deir57ugykbh', '2023-01-20 20:01:37'),
(21, 3, 7, 'iuklok,', '2023-01-20 20:38:59'),
(22, 3, 7, 'iuklok,cfgh', '2023-01-20 20:42:14'),
(23, 7, 3, 'teste', '2023-01-20 21:25:43'),
(24, 7, 3, 'aaaaaaa', '2023-01-20 21:42:07'),
(28, 7, 3, 'teadafea', '2023-01-20 21:43:44'),
(29, 7, 3, 'Minha mensagem', '2023-01-20 21:48:44'),
(30, 7, 3, '', '2023-01-20 21:51:52'),
(31, 7, 3, 'aaadaaa', '2023-01-20 21:52:50'),
(32, 7, 3, 'aaadaaa', '2023-01-20 21:52:52'),
(33, 7, 3, 'aaadaaa', '2023-01-20 21:52:54'),
(34, 7, 3, 'aaadaaa', '2023-01-20 21:53:03'),
(35, 7, 3, 'aaadaaa', '2023-01-20 21:53:04'),
(36, 3, 7, 'teste', '2023-01-20 21:55:12'),
(37, 3, 7, 'teste', '2023-01-20 21:55:15'),
(38, 3, 7, 'teste', '2023-01-20 21:55:15'),
(39, 3, 7, 'teste23', '2023-01-20 21:55:17');

-- --------------------------------------------------------

--
-- Estrutura da tabela `friend`
--

CREATE TABLE `friend` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `friend` int(11) NOT NULL,
  `blocked` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `joinlinks`
--

CREATE TABLE `joinlinks` (
  `id` int(11) NOT NULL,
  `chatId` int(11) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `menbers`
--

CREATE TABLE `menbers` (
  `id` int(11) NOT NULL,
  `chatId` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `menbers`
--

INSERT INTO `menbers` (`id`, `chatId`, `role`, `user`) VALUES
(1, 1, 2, 1),
(2, 2, 4, 1),
(3, 3, 6, 1),
(4, 4, 8, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `chatId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `content` varchar(4000) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `notfy`
--

CREATE TABLE `notfy` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `chatId` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `chatId` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `roles`
--

INSERT INTO `roles` (`id`, `chatId`, `role`) VALUES
(1, 1, 'everyone'),
(2, 1, 'owner'),
(3, 2, 'everyone'),
(4, 2, 'owner'),
(5, 3, 'everyone'),
(6, 3, 'owner'),
(7, 4, 'everyone'),
(8, 4, 'owner');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Nome` varchar(255) NOT NULL,
  `Token` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `tag`, `Email`, `Password`, `Nome`, `Token`) VALUES
(1, '7180', 'admin@admin.com', 'e10adc3949ba59abbe56e057f20f883e', 'Thiago Santos', 'b1695e2210e88d6cdc83c44b04b042ae'),
(2, '8608', 'email3@email.com', 'e10adc3949ba59abbe56e057f20f883e', 'teste', '594b1795fee8c6dd8f2cb2d8e423146f'),
(3, '4209', 'xiribe2@email.com', 'e10adc3949ba59abbe56e057f20f883e', 'xiribe', '1f0ef484a40abc4a76fbdb412cc752a7'),
(4, '8311', 'teste5@email.com', '202cb962ac59075b964b07152d234b70', 'teste', '636dbcc01b3da56e6768b425565cac5f'),
(5, '6953', 'email6@email.com', '202cb962ac59075b964b07152d234b70', 'teste7', '229e16509ef2563b8bc4d529930857df'),
(6, '3439', 'email9@email.com', 'e10adc3949ba59abbe56e057f20f883e', 'teste9', '11c47ac3853d896098856724920de745'),
(7, '3232', 'thiago@email.com', 'e10adc3949ba59abbe56e057f20f883e', 'Thiago ', '5c9cbc4a3c979868774be068274c3771');

-- --------------------------------------------------------

--
-- Estrutura da tabela `userconfig`
--

CREATE TABLE `userconfig` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `userconfig`
--

INSERT INTO `userconfig` (`id`, `user`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IdUnique` (`IdUnique`),
  ADD KEY `owner` (`owner`);

--
-- Índices para tabela `chatconfig`
--
ALTER TABLE `chatconfig`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat` (`chat`);

--
-- Índices para tabela `directmessage`
--
ALTER TABLE `directmessage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `friend` (`friend`);

--
-- Índices para tabela `friend`
--
ALTER TABLE `friend`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `friend` (`friend`);

--
-- Índices para tabela `joinlinks`
--
ALTER TABLE `joinlinks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `chatId` (`chatId`);

--
-- Índices para tabela `menbers`
--
ALTER TABLE `menbers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chatId` (`chatId`),
  ADD KEY `role` (`role`),
  ADD KEY `user` (`user`);

--
-- Índices para tabela `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chatId` (`chatId`),
  ADD KEY `userId` (`userId`);

--
-- Índices para tabela `notfy`
--
ALTER TABLE `notfy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `author` (`author`),
  ADD KEY `chatId` (`chatId`);

--
-- Índices para tabela `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chatId` (`chatId`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Índices para tabela `userconfig`
--
ALTER TABLE `userconfig`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `chatconfig`
--
ALTER TABLE `chatconfig`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `directmessage`
--
ALTER TABLE `directmessage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `friend`
--
ALTER TABLE `friend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `joinlinks`
--
ALTER TABLE `joinlinks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `menbers`
--
ALTER TABLE `menbers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `notfy`
--
ALTER TABLE `notfy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `userconfig`
--
ALTER TABLE `userconfig`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `user` (`id`);

--
-- Limitadores para a tabela `chatconfig`
--
ALTER TABLE `chatconfig`
  ADD CONSTRAINT `chatconfig_ibfk_1` FOREIGN KEY (`chat`) REFERENCES `chat` (`id`);

--
-- Limitadores para a tabela `directmessage`
--
ALTER TABLE `directmessage`
  ADD CONSTRAINT `directmessage_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `directmessage_ibfk_2` FOREIGN KEY (`friend`) REFERENCES `user` (`id`);

--
-- Limitadores para a tabela `friend`
--
ALTER TABLE `friend`
  ADD CONSTRAINT `friend_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `friend_ibfk_2` FOREIGN KEY (`friend`) REFERENCES `user` (`id`);

--
-- Limitadores para a tabela `joinlinks`
--
ALTER TABLE `joinlinks`
  ADD CONSTRAINT `joinlinks_ibfk_1` FOREIGN KEY (`chatId`) REFERENCES `chat` (`id`);

--
-- Limitadores para a tabela `menbers`
--
ALTER TABLE `menbers`
  ADD CONSTRAINT `menbers_ibfk_1` FOREIGN KEY (`chatId`) REFERENCES `chat` (`id`),
  ADD CONSTRAINT `menbers_ibfk_2` FOREIGN KEY (`role`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `menbers_ibfk_3` FOREIGN KEY (`user`) REFERENCES `user` (`id`);

--
-- Limitadores para a tabela `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`chatId`) REFERENCES `chat` (`id`),
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

--
-- Limitadores para a tabela `notfy`
--
ALTER TABLE `notfy`
  ADD CONSTRAINT `notfy_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `notfy_ibfk_2` FOREIGN KEY (`author`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `notfy_ibfk_3` FOREIGN KEY (`chatId`) REFERENCES `chat` (`id`);

--
-- Limitadores para a tabela `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_ibfk_1` FOREIGN KEY (`chatId`) REFERENCES `chat` (`id`);

--
-- Limitadores para a tabela `userconfig`
--
ALTER TABLE `userconfig`
  ADD CONSTRAINT `userconfig_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
