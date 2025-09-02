import React, {useEffect, useState} from 'react';
import API from '../api';

export default function Teachers(){
  const [list, setList] = useState([]);
  const [err, setErr] = useState('');

  useEffect(()=>{ fetchData(); },[]);
  const fetchData = async ()=>{
    try{
      const res = await API.get('/api/teachers');
      setList(res.data);
    }catch(e){ setErr('Failed to fetch'); }
  }

  return (
    <div style={{padding:20}}>
      <h2>Teachers</h2>
      {err && <div>{err}</div>}
      <table border='1' cellPadding='6'>
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>University</th><th>Year Joined</th></tr></thead>
        <tbody>
          {list.map(t => (
            <tr key={t.id}>
              <td>{t.id}</td>
              <td>{t.first_name} {t.last_name}</td>
              <td>{t.email}</td>
              <td>{t.university_name}</td>
              <td>{t.year_joined}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  )
}
