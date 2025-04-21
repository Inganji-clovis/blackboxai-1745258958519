import React, { useState } from 'react';
import axios from 'axios';

const Register = ({ onRoleSelect }) => {
  const [step, setStep] = useState(1);
  const [role, setRole] = useState('');
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
  });
  const [error, setError] = useState('');

  const handleRoleSelect = (selectedRole) => {
    setRole(selectedRole);
    setStep(2);
    if (onRoleSelect) onRoleSelect(selectedRole);
  };

  const handleChange = (e) => {
    setFormData({...formData, [e.target.name]: e.target.value});
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    try {
      await axios.post('/api/register', {
        ...formData,
        role,
      });
      alert('Registration successful! Please login.');
      // Redirect to login or other page as needed
    } catch (err) {
      setError(err.response?.data?.message || 'Registration failed');
    }
  };

  if (step === 1) {
    return (
      <div className="register-role-choice">
        <h2>Select Role</h2>
        <button onClick={() => handleRoleSelect('teacher')}>Teacher</button>
        <button onClick={() => handleRoleSelect('student')}>Student</button>
      </div>
    );
  }

  return (
    <form onSubmit={handleSubmit} className="register-form">
      <h2>Register as {role}</h2>
      {error && <p className="error">{error}</p>}
      <input type="text" name="name" placeholder="Name" value={formData.name} onChange={handleChange} required />
      <input type="email" name="email" placeholder="Email" value={formData.email} onChange={handleChange} required />
      <input type="password" name="password" placeholder="Password" value={formData.password} onChange={handleChange} required />
      <input type="password" name="password_confirmation" placeholder="Confirm Password" value={formData.password_confirmation} onChange={handleChange} required />
      <button type="submit">Register</button>
    </form>
  );
};

export default Register;
