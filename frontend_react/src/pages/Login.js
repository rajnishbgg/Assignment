import React, {useState} from 'react';
import API from '../api';
import { useNavigate } from 'react-router-dom';

export default function Login(){
  const [form, setForm] = useState({email:'', password:''});
  const [msg, setMsg] = useState('');
  const nav = useNavigate();

  const onChange = e => setForm({...form, [e.target.name]: e.target.value});
  const submit = async e => {
    e.preventDefault();
    try{
      const res = await API.post('/api/login', form);
      localStorage.setItem('token', res.data.token);
      nav('/teachers');
    }catch(err){ setMsg(err?.response?.data?.message || 'Login failed'); }
  }

  return (
    <div style={{padding:20}}>
      <h2>Login</h2>
      <form onSubmit={submit}>
        <input name='email' placeholder='Email' onChange={onChange} /> <br/>
        <input name='password' placeholder='Password' type='password' onChange={onChange} /> <br/>
        <button type='submit'>Login</button>
      </form>
      <p>{msg}</p>
    </div>
  )
}
