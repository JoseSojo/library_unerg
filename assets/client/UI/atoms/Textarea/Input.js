import React from 'react';

const Textarea = ({ customClass, change=()=>{}, name, value,placeholder=`` }) => {

    const ChageController = (e) => { 
        if(change) change(e.target.value)
    };

    return <textarea
        name={name}
        placeholder={placeholder}
        onChange={ChageController}
        className={`${customClass}`}
    >{value}</textarea>
}

export default Textarea;

