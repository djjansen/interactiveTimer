-- Inferred schema, reconstructed from the queries in req.php, xm.php, and
-- OverUnder.php. No original backup was available, so column types/sizes
-- are best-effort guesses — adjust if a real backup surfaces later.

CREATE TABLE IF NOT EXISTS timer (
  id INT AUTO_INCREMENT PRIMARY KEY,
  time DATETIME NOT NULL,
  status VARCHAR(20) NOT NULL,
  readout VARCHAR(20) NOT NULL,
  INDEX idx_timer_time (time),
  INDEX idx_timer_status_time (status, time)
);

CREATE TABLE IF NOT EXISTS OverUnder (
  id INT AUTO_INCREMENT PRIMARY KEY,
  time DATETIME NOT NULL,
  readout VARCHAR(20) NOT NULL,
  OverUnder VARCHAR(20) NOT NULL,
  vote VARCHAR(10) DEFAULT NULL,
  INDEX idx_overunder_time (time),
  INDEX idx_overunder_time_vote (time, vote)
);

-- Seed one row in each table so a fresh database starts in the same state
-- as a cleared timer, instead of req.php hitting empty result sets.
INSERT INTO timer (time, status, readout) VALUES (NOW(), 'clear', '00:00:00');
INSERT INTO OverUnder (time, readout, OverUnder, vote) VALUES (NOW(), '00:00:00', '0', NULL);
