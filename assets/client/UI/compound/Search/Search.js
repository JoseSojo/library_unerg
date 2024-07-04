import React, {useState} from 'react';
import Input from '../../atoms/Input/Input';
import Button from '../../atoms/Button/Button';
import { Row, Col, Form } from 'react-bootstrap';
import { useSearch } from '../../../context/SearchContext';

const Search = ({ customClass='' }) => {
    
    const [active, setActive] = useState(false);
    const search = useSearch();
    const [valueSearch, setValueSearch] = useState(``);

    const SubmitController = (e) => {
        e.preventDefault();

        const previwValue = search.valuesSearch;

        if(!valueSearch) return;

        previwValue.push({ key:`author`, value:valueSearch });
        // previwValue.push({ key:`keyword`, value:valueSearch });
        // previwValue.push({ key:`resumen`, value:valueSearch });

        search.setValuesSearch(previwValue);
        search.Buscar();        
    }

    return <Row
        className={`${customClass} `}
    >
        <Form onSubmit={SubmitController}>
            <Row className='m-auto' onSubmit={SubmitController}>
                <Col className='m-auto' xs={3}>
                    <Button 
                        customClass=''
                        type='submit'
                    >
                        <i className="bi bi-search">buscar</i>
                    </Button>
                </Col>
                <Col className='m-auto' xs={9}>
                    <Input 
                        customClass='border outline-none px-5 py-1 rounded-[20px]' 
                        name='search' 
                        change={setValueSearch} 
                        type='text' 
                        value={valueSearch}
                        /> 
                </Col>
            </Row>
        </Form>
    </Row>
}

export default Search;

