import React, { useState } from 'react';
import Register from './components/Register';
import Login from './components/Login';

const App = () => {
  const [user, setUser] = useState(null);

  const handleLogin = (data) => {
    setUser({
      token: data.access_token,
      role: data.role,
    });
  };

  const handleLogout = () => {
    setUser(null);
  };

  if (!user) {
    return (
      <div>
        <h1>Welcome to M|yGe|nZ</h1>
        <Register />
        <Login onLogin={handleLogin} />
      </div>
    );
  }

  if (user.role === 'teacher') {
    return (
      <div>
        <h2>Teacher Dashboard</h2>
        <button onClick={handleLogout}>Logout</button>
        {/* Teacher components and pages go here */}
      </div>
    );
  }

  if (user.role === 'student') {
    return (
      <div>
        <h2>Student Dashboard</h2>
        <button onClick={handleLogout}>Logout</button>
        {/* Student components and pages go here */}
      </div>
    );
  }

  return null;
};

export default App;
