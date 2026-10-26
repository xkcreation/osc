const express = require("express");
const session = require("express-session");
const path = require("path");

const app = express();
const PORT = 3000;

// Middleware
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, "public")));
app.use(
  session({
    secret: "student-registration-secret",
    resave: false,
    saveUninitialized: false,
  }),
);

// Login page
app.get("/", (req, res) => {
  res.sendFile(path.join(__dirname, "views", "login.html"));
});

// Login
app.post("/login", (req, res) => {
  const { username, password } = req.body;
  if (username === "admin" && password === "1234") {
    req.session.loggedIn = true;
    res.redirect("/register");
  } else {
    res.send(`
      <h2>Invalid username or password</h2>
      <a href="/">Back to Login</a>
    `);
  }
});

// Registration page
app.get("/register", (req, res) => {
  if (!req.session.loggedIn) {
    return res.redirect("/");
  }
  res.sendFile(path.join(__dirname, "views", "register.html"));
});

// Handle registration
app.post("/register", (req, res) => {
  if (!req.session.loggedIn) {
    return res.redirect("/");
  }

  const { name, regno, email, mobile, gender, dob, department, course, year, address, skills } = req.body;

  // Validation
  if (!name || !regno || !email || !mobile || !gender || !dob || !department || !course || !year || !address) {
    return res.send(`
      <h2>All required fields must be filled.</h2>
      <a href="/register">Go Back</a>
    `);
  }

  // Email validation
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email)) {
    return res.send(`
      <h2>Invalid email address.</h2>
      <a href="/register">Go Back</a>
    `);
  }

  // Mobile validation
  const mobilePattern = /^[0-9]{10}$/;
  if (!mobilePattern.test(mobile)) {
    return res.send(`
      <h2>Mobile number must contain exactly 10 digits.</h2>
      <a href="/register">Go Back</a>
    `);
  }

  // Store student details in session
  req.session.student = {
    name, regno, email, mobile, gender, dob, department, course, year, address,
    skills: skills || "None",
  };

  res.redirect("/student");
});

// Display student details
app.get("/student", (req, res) => {
  if (!req.session.loggedIn) {
    return res.redirect("/");
  }
  if (!req.session.student) {
    return res.redirect("/register");
  }
  res.sendFile(path.join(__dirname, "views", "student.html"));
});

// Student data API used by student.html
app.get("/student-data", (req, res) => {
  if (!req.session.loggedIn) {
    return res.status(401).json({ error: "Unauthorized" });
  }
  res.json(req.session.student);
});

// Logout
app.get("/logout", (req, res) => {
  req.session.destroy(() => {
    res.redirect("/");
  });
});

app.listen(PORT, () => {
  console.log(`Server running at http://localhost:${PORT}`);
});
