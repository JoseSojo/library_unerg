import React, { useEffect, useState } from 'react';
import { Form, FormLabel } from 'react-bootstrap';
import { useSearch } from '../../../context/SearchContext';

const Select = ({ name, change, valueChange, list }) => {
    
    const search = useSearch();

    return (
        <>
        <FormLabel>
            {name}
        </FormLabel>
        <Form.Select className='form-control' onChange={(e)=>change(e.target.value)} aria-label={`selecciona una ${name}`}>
            {
                list.length == 0
                ? <option className='' disabled>no hay {name}</option>
                : <>
                <option className='' value="" selected>seleccione una opción</option>
                {
                    list.map((item, i) => (
                        <option key={item.id} value={item.name}>{item.name}</option>
                    ))
                }
                </>
            }
        </Form.Select>
        </>
    )
}

export default Select;
