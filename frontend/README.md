# Frontend Applications

This directory contains the React frontend applications for the Sir Isaac Newton School Management Platform.

## Applications

1. **driver-tool** - Progressive Web App for transport drivers
2. **parent-portal** - Single Page Application for parents
3. **teacher-portal** - Single Page Application for teachers

## Setup

Each application has its own directory with its own `package.json`. Navigate to each directory and run:

```bash
npm install
npm run dev
```

## API Base URL

All applications connect to: `http://localhost:8000/api/v1`

Update the API base URL in each app's configuration file for production.

