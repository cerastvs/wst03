CREATE DATABASE IF NOT EXISTS jobseeker;
USE jobseeker;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    city VARCHAR(255),
    state VARCHAR(255),
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS job_listings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    salary VARCHAR(255),
    tags VARCHAR(255),
    company VARCHAR(255),
    address VARCHAR(255),
    city VARCHAR(255),
    state VARCHAR(255),
    phone VARCHAR(255),
    email VARCHAR(255),
    requirements TEXT,
    benefits TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users (id, name, email, city, state, password) VALUES
(1, 'Admin User', 'admin@example.com', 'Albany', 'NY', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(2, 'Marketing Lead', 'marketing@example.com', 'San Francisco', 'CA', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(3, 'Web Manager', 'web@example.com', 'Chicago', 'IL', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO job_listings (user_id, title, description, salary, tags, company, address, city, state, phone, email, requirements, benefits) VALUES
(1, 'Software Engineer', 'We are seeking a skilled software engineer to develop high-quality software solutions', '90000', 'development, coding, java, python', 'Tech Solutions Inc.', '123 Main St', 'Albany', 'NY', '348-334-3949', 'info@techsolutions.com', 'Bachelors degree in Computer Science or related field, 3+ years of software development experience', 'Healthcare, 401(k) matching, flexible work hours'),
(2, 'Marketing Specialist', 'We are looking for a Marketing Specialist to create and manage marketing campaigns', '70000', 'marketing, advertising', 'Marketing Pros', '456 Market St', 'San Francisco', 'CA', '454-344-3344', 'info@marketingpros.com', 'Bachelors degree in Marketing or related field, experience in digital marketing', 'Health and dental insurance, paid time off, remote work options'),
(3, 'Web Developer', 'Join our team as a Web Developer and create amazing web applications', '85000', 'web development, programming', 'WebTech Solutions', '789 Web Ave', 'Chicago', 'IL', '456-876-5432', 'info@webtechsolutions.com', 'Bachelors degree in Computer Science or related field, proficiency in HTML, CSS, JavaScript', 'Competitive salary, professional development opportunities, friendly work environment'),
(1, 'Data Analyst', 'We are hiring a Data Analyst to analyze and interpret data for insights', '75000', 'data analysis, statistics', 'Data Insights LLC', '101 Data St', 'Chicago', 'IL', '444-555-5555', 'info@datainsights.com', 'Bachelors degree in Data Science or related field, strong analytical skills', 'Health benefits, remote work options, casual dress code'),
(2, 'Graphic Designer', 'Join our creative team as a Graphic Designer and bring ideas to life', '70000', 'graphic design, creative', 'CreativeWorks Inc.', '234 Design Blvd', 'Albany', 'NY', '499-321-9876', 'info@creativeworks.com', 'Bachelors degree in Graphic Design or related field, proficiency in Adobe Creative Suite', 'Flexible work hours, creative work environment, opportunities for growth'),
(1, 'Data Scientist', 'We\'re looking for a Data Scientist to analyze complex data and generate insights', '100000', 'data science, machine learning', 'DataGenius Corp', '567 Data Drive', 'Boston', 'MA', '684-789-1234', 'info@datagenius.com', 'Masters or Ph.D. in Data Science or related field, experience with machine learning algorithms', 'Competitive salary, remote work options, professional development');
