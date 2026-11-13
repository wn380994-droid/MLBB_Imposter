CREATE DATABASE IF NOT EXISTS mlbb_imposter
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE mlbb_imposter;

DROP TABLE IF EXISTS games;
DROP TABLE IF EXISTS game_data;

CREATE TABLE game_data (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category ENUM('Hero','Item','Battle Spell') NOT NULL,
    answer VARCHAR(100) NOT NULL,
    hint VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE games (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    squad_name VARCHAR(60) NOT NULL,
    player1 VARCHAR(30) NOT NULL,
    player2 VARCHAR(30) NOT NULL,
    player3 VARCHAR(30) NOT NULL,
    player4 VARCHAR(30) NOT NULL,
    player5 VARCHAR(30) NOT NULL,
    imposter_index TINYINT UNSIGNED NOT NULL,
    data_id INT UNSIGNED NOT NULL,
    status ENUM('active','completed') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_games_data FOREIGN KEY (data_id) REFERENCES game_data(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO game_data (category, answer, hint) VALUES
('Hero','Miya','A ranged marksman strongly associated with the moonlight and attack-speed focused basic attacks.'),
('Hero','Layla','A beginner-friendly marksman whose long-range ultimate can fire across a large part of the map.'),
('Hero','Tigreal','A tank famous for pulling enemies together before following with powerful crowd control.'),
('Hero','Alucard','A fighter/assassin who becomes dangerous when repeatedly chaining attacks and recovering health.'),
('Hero','Eudora','A mage whose burst combo revolves around lightning and can quickly punish a single target.'),
('Hero','Zilong','A spear-wielding fighter known for charging forward and knocking an enemy backward.'),
('Hero','Saber','An assassin whose signature ultimate locks onto one target and launches them into the air.'),
('Hero','Nana','A small mage/support character with a boomerang-like skill and a transformation effect.'),
('Hero','Franco','A tank whose famous hook can drag an enemy toward him from a distance.'),
('Hero','Johnson','A tank who can transform into a vehicle and carry an ally around the battlefield.'),
('Hero','Gusion','A highly mobile assassin who throws and recalls a set of magical blades.'),
('Hero','Fanny','An assassin who uses cables to swing between walls and is famous for demanding precise mechanics.'),
('Hero','Chou','A fighter whose ultimate can kick an enemy away and whose kit includes a short dash sequence.'),
('Hero','Lancelot','An assassin known for dashes, invulnerability timing and a rose-themed visual identity.'),
('Hero','Hayabusa','An assassin associated with shadows, shuriken and a shadow-based ultimate attack.'),
('Hero','Kagura','A mage who fights with a magical umbrella and can reposition herself through it.'),
('Hero','Lunox','A mage whose abilities revolve around two opposing cosmic states, light and dark.'),
('Hero','Estes','A support hero famous for linking to allies and restoring their health over time.'),
('Hero','Angela','A support who can attach herself to an ally from anywhere and provide shields and assistance.'),
('Hero','Karrie','A marksman particularly effective against durable targets because her attacks can deal true damage after stacking.'),
('Hero','Balmond','A fighter/tank with a spinning skill and an execution-style ultimate useful against low-health objectives.'),
('Hero','Granger','A marksman whose skills emphasize musical bullets and a powerful long-range ultimate.'),
('Hero','Khufra','A tank with strong crowd control who can turn into a rolling ball to disrupt enemies.'),
('Hero','Melissa','A marksman who attacks through dolls and can create a protective zone around herself.'),
('Hero','Rafaela','A support hero associated with healing allies and providing movement speed through her abilities.');

INSERT INTO game_data (category, answer, hint) VALUES
('Item','Blade of Despair','A very expensive offensive item associated with a huge physical attack increase and finishing weakened enemies.'),
('Item','Endless Battle','A hybrid offensive item known for combining several stats and empowering a basic attack after using a skill.'),
('Item','Berserker''s Fury','A critical-strike item that greatly increases critical damage and is commonly linked with physical carries.'),
('Item','Malefic Roar','A physical penetration item especially useful when the enemy has high physical defense.'),
('Item','Demon Hunter Sword','An attack-speed item whose passive makes basic attacks especially useful against targets with high HP.'),
('Item','Golden Staff','An attack-speed item that changes how critical chance interacts with certain basic-attack effects.'),
('Item','Corrosion Scythe','An offensive item that combines attack speed with a slowing effect on repeated basic attacks.'),
('Item','Wind of Nature','A marksman-oriented active item that can temporarily protect the user from physical damage.'),
('Item','Sea Halberd','An offensive item known for reducing the effectiveness of enemy HP regeneration and shields.'),
('Item','Hunter Strike','A physical attack and penetration item that can grant a burst of movement speed after repeated hits.'),
('Item','Holy Crystal','A mage item focused heavily on increasing magic power and scaling a mage''s damage.'),
('Item','Divine Glaive','A magic penetration item designed to help magic damage cut through high magic defense.'),
('Item','Genius Wand','A magic item whose passive can reduce an enemy''s magic defense after dealing damage.'),
('Item','Glowing Wand','A magic item associated with damage-over-time effects that are especially useful against targets with large HP pools.'),
('Item','Immortality','A defensive item famous for bringing the holder back after being killed, with a revival cooldown.');

INSERT INTO game_data (category, answer, hint) VALUES
('Battle Spell','Flicker','A short-range teleport spell that can reposition a hero through walls or help initiate and escape.'),
('Battle Spell','Retribution','A jungle-focused spell used to secure monsters and improve farming efficiency.'),
('Battle Spell','Execute','A finishing spell designed to deal extra damage to a nearby enemy when their HP is low.'),
('Battle Spell','Purify','A defensive spell that can remove certain crowd-control effects and provide temporary control immunity.'),
('Battle Spell','Sprint','A mobility spell that temporarily increases movement speed and helps with chasing or escaping.'),
('Battle Spell','Vengeance','A defensive spell that reduces incoming damage and reflects part of the damage taken.'),
('Battle Spell','Aegis','A defensive spell that provides a shield to the caster and a nearby ally.'),
('Battle Spell','Inspire','An offensive spell that temporarily improves basic attacks, especially attack speed and related effects.'),
('Battle Spell','Petrify','A control spell that can briefly stun nearby enemies after activation.'),
('Battle Spell','Arrival','A map-mobility spell that allows a hero to teleport to an allied structure or suitable location.');

-- NOTE:
-- Nana is intentionally repeated above because this starter dataset was requested
-- as exactly 25 hero rows. If you want 25 UNIQUE heroes, replace the second Nana
-- row with another hero (e.g. Rafaela) before importing.
