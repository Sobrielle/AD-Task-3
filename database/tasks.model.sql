CREATE TABLE IF NOT EXISTS tasks (
    id SERIAL PRIMARY KEY,
    task_name VARCHAR(100) NOT NULL,
    description TEXT,
    status VARCHAR(30) DEFAULT 'Pending',
    due_date DATE,
    assigned_to INTEGER REFERENCES users(id),
    meeting_id INTEGER REFERENCES meetings(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
