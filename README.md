# CSC318---FootCity-Final
# PHP E-Commerce Storefront

## Overview
A dynamic, full-stack e-commerce web application built with PHP and a relational SQL database. This platform provides a complete shopping experience, from browsing product catalogs to secure user authentication and cart management.

---

## 🛒 User Guide

### Browsing and Purchasing
* **Product Discovery:** View the entire catalog directly from the main index page. Clicking on any specific shoe redirects to a dedicated product page containing granular details.
* **Cart Operations:** On a product page, select a required variant and specify a quantity before adding the item to the active shopping cart.
* **Checkout Process:** A dedicated checkout portal allows authenticated shoppers to review their pending inventory and finalize their purchase.

### Account Management
* **Registration:** First-time visitors must create a profile using the registration form to unlock full platform features, including the ability to purchase items.
* **Authentication:** Registered users authenticate via the login portal. This updates the navigation bar with a personalized greeting and enables the checkout workflow.
* **Session Termination:** A dedicated logout link safely terminates the active session, clearing cached credentials and returning the user to the public homepage.

---

## 💻 Developer Guide

### Technical Stack
* **Core Technologies:** The backend relies heavily on robust PHP scripts, while the frontend utilizes standard HTML structures. A relational SQL database handles persistent data for products, users, and carts.
* **State Management:** Global `$_SESSION` variables are employed to track user login status across the application and protect restricted routes from unauthorized access.
* **Dynamic Rendering:** Product displays are generated dynamically. URL parameters are captured via `$_GET` requests to query specific database records and populate a single product template.

### Security Implementation
* **Credential Hashing:** User passwords are mathematically hashed during registration and securely verified during login, ensuring plaintext credentials are never stored.
