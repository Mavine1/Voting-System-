# Use Node.js as the base image
FROM node:18

# Set the working directory
WORKDIR /app

# Copy package.json and install dependencies
COPY package*.json ./
RUN npm install

# Copy the rest of the application
COPY . .

# Build the React app for production
RUN npm run build

# Expose the React app port
EXPOSE 3000

# Start the React app
CMD ["npm", "start"]
