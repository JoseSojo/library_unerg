import React from 'react';

const Textarea = ({ customClass, change=()=>{}, name, value,placeholder=`` }) => {

    const ChageController = (e) => { 
        if(change) change(e.target.value);
    };

    return <textarea
        defaultValue={value}
        value={value}
        name={name}
        placeholder={placeholder}
        onChange={ChageController}
        className={`${customClass}`}
    ></textarea>
}

export default Textarea;

