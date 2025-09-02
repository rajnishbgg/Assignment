import React, {useState} from 'react';
import API from '../api';

export default function Register(){
  const [form, setForm] = useState({email:'', first_name:'', last_name:'', password:'', university_name:'', gender:'other', year_joined:''});
  const [msg, setMsg] = useState('');

  const onChange = e => setForm({...form, [e.target.name]: e.target.value});

  const submit = async e => {
    e.preventDefault();
    try{
      const res = await API.post('/api/register', form);
      setMsg('Registered. You can now login.');
    }catch(err){
      setMsg(err?.response?.data?.message || JSON.stringify(err?.response?.data) || 'Error');
    }
  }

  return (
    <div style={{padding:20}}>
      <h2>Register</h2>
      <form onSubmit={submit}>
        <input name='email' placeholder='Email' onChange={onChange} /> <br/>
        <input name='first_name' placeholder='First name' onChange={onChange} /> <br/>
        <input name='last_name' placeholder='Last name' onChange={onChange} /> <br/>
        <input name='password' placeholder='Password' type='password' onChange={onChange} /> <br/>
        <input name='university_name' placeholder='University' onChange={onChange} /> <br/>
        <select name='gender' onChange={onChange} value={form.gender}><option value='male'>Male</option><option value='female'>Female</option><option value='other'>Other</option></select><br/>
        <input name='year_joined' placeholder='Year Joined' onChange={onChange} /> <br/>
        <button type='submit'>Register</button>
      </form>
      <p>{msg}</p>
    </div>
  )
}
