require("dotenv").config();
const express = require("express");
const mongoose = require("mongoose");
const session = require("express-session");
const bcrypt = require("bcryptjs");

const Admin = require("./models/Admin");
const Employee = require("./models/Employee");

const app = express();

// Middleware
app.set("view engine", "ejs");
app.use(express.urlencoded({ extended: true }));
app.use(
  session({
    secret: "my-super-secret-key",
    resave: false,
    saveUninitialized: false,
  }),
);

// MongoDB Connection
mongoose
  .connect(process.env.MONGO_URI || "mongodb://127.0.0.1:27017/EmployeeDB")
  .then(async () => {
    console.log("Connected to MongoDB");
    const adminExists = await Admin.findOne({ username: "admin" });
    if (!adminExists) {
      const hashedPassword = await bcrypt.hash("password123", 10);
      await Admin.create({ username: "admin", password: hashedPassword });
      console.log("Default admin created (Username: admin, Password: password123)");
    }
  })
  .catch((err) => console.log(err));

// Authentication Middleware
const requireAuth = (req, res, next) => {
  if (req.session.adminId) {
    next();
  } else {
    res.redirect("/login");
  }
};

// --- ROUTES ---
app.get("/login", (req, res) => res.render("login", { error: null }));

app.post("/login", async (req, res) => {
  const { username, password } = req.body;
  const admin = await Admin.findOne({ username });
  if (admin && (await bcrypt.compare(password, admin.password))) {
    req.session.adminId = admin._id;
    res.redirect("/");
  } else {
    res.render("login", { error: "Invalid username or password" });
  }
});

app.get("/logout", (req, res) => {
  req.session.destroy();
  res.redirect("/login");
});

// Dashboard
app.get("/", requireAuth, async (req, res) => {
  const { search, department } = req.query;
  let query = {};
  if (search) query.name = new RegExp(search, "i");
  if (department) query.department = department;

  const employees = await Employee.find(query).sort({ joiningDate: -1 });
  const departments = await Employee.distinct("department");
  res.render("dashboard", {
    employees,
    departments,
    searchQuery: search,
    deptQuery: department,
  });
});

// Add Employee
app.get("/add", requireAuth, (req, res) => res.render("add"));

app.post("/add", requireAuth, async (req, res) => {
  try {
    const newEmployee = new Employee({
      ...req.body,
      skills: (req.body.skills || "").split(",").map((skill) => skill.trim()).filter(Boolean),
    });
    await newEmployee.save();
    res.redirect("/");
  } catch (err) {
    res.send("Error saving employee. Ensure Emp ID is unique.");
  }
});

// View Single Employee
app.get("/view/:id", requireAuth, async (req, res) => {
  const employee = await Employee.findById(req.params.id);
  if (!employee) return res.status(404).send("Employee not found");
  res.render("view", { employee });
});

// Edit Employee
app.get("/edit/:id", requireAuth, async (req, res) => {
  const employee = await Employee.findById(req.params.id);
  res.render("edit", { employee });
});

app.post("/edit/:id", requireAuth, async (req, res) => {
  await Employee.findByIdAndUpdate(req.params.id, {
    ...req.body,
    skills: (req.body.skills || "").split(",").map((skill) => skill.trim()).filter(Boolean),
  });
  res.redirect("/");
});

// Delete Employee
app.post("/delete/:id", requireAuth, async (req, res) => {
  await Employee.findByIdAndDelete(req.params.id);
  res.redirect("/");
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () =>
  console.log(`Server running on http://localhost:${PORT}`),
);
