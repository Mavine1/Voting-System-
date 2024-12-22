import axios from "axios";

// Ensure API_BASE_URL is defined
// const API_BASE_URL = process.env.REACT_APP_API_BASE_URL || "http://localhost:8000";

// const service = axios.create({
//   baseURL: `${API_BASE_URL}/api`, // Base URL for all API calls
//   timeout: 60000, // Timeout of 60 seconds
//   headers: {
//     "Content-Type": "application/json", // Default header for JSON requests
//   },
// });

// // Add request interceptor (optional, for example, adding auth token)
// service.interceptors.request.use(
//   (config) => {
//     // Example: Add authorization token if available
//     const token = localStorage.getItem("authToken");
//     if (token) {
//       config.headers.Authorization = `Bearer ${token}`;
//     }
//     return config;
//   },
//   (error) => {
//     return Promise.reject(error);
//   }
// );

// // Add response interceptor (optional, for handling responses globally)
// service.interceptors.response.use(
//   (response) => response,
//   (error) => {
//     // Example: Handle unauthorized errors
//     if (error.response && error.response.status === 401) {
//       console.error("Unauthorized! Please login again.");
//     }
//     return Promise.reject(error);
//   }
// );

// export default service;

let API_BASE_URL = 'http://localhost:8000/api'


const service = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
  },
  withCredentials:true,
});

export default service