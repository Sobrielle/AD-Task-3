CREATE TABLE IF NOT EXISTS meeting (
    id SERIAL PRIMARY KEY,
    meeting_name VARCHAR(100) NOT NULL,
    description TEXT,
    start_date DATE,
    end_date DATE
);
