import React from 'react';
import { Form } from 'react-bootstrap';

const Input = ({ customClass, type=`text`, change, name, value }) => {

    const ChageController = (e) => change(e.target.value);

    return <Form.Control 
        type={type}
        name={name}
        onChange={ChageController}
        className={`${customClass}`}
        value={value}
    />
}

export default Input;

