import React from 'react';
import { BrowserRouter, Routes, Route, Link } from 'react-router-dom';
import Register from './pages/Register';
import Login from './pages/Login';
import Teachers from './pages/Teachers';
import Home from './pages/Home';
import ProtectedRoute from './components/ProtectedRoute';

function App(){
  return (
    <BrowserRouter>
      <nav style={{padding:10}}>
        <Link to='/'>Home</Link> | <Link to='/register'>Register</Link> | <Link to='/login'>Login</Link> | <Link to='/teachers'>Teachers</Link>
      </nav>
      <Routes>
        <Route path='/' element={<Home/>} />
        <Route path='/register' element={<Register/>} />
        <Route path='/login' element={<Login/>} />
        <Route path='/teachers' element={<ProtectedRoute><Teachers/></ProtectedRoute>} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
