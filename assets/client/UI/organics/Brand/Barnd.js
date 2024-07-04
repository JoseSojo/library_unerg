import React, { useState } from 'react';
import { Container, Card, CardBody, Row, Col, Form, FormLabel  } from 'react-bootstrap';
import Select from '../../atoms/Select/Select';
import { useSearch } from '../../../context/SearchContext';
import Button from '../../atoms/Button/Button';

const Brand = () => {   
    const [category, setCategory] = useState(``);
    const [program, setProgram] = useState(``);
    const [investigationLine, setInvestigationLine] = useState(``);
    // const [limit, setLimit] = useState(10);
    const search = useSearch();
    
    const SubmitController = (e) => {
        e.preventDefault();

        const searchData = search.valuesSearch;
        if(category) searchData.push({ key:"category", value:category });
        if(investigationLine) searchData.push({ key:"investigationLine", value:investigationLine });
        if(program) searchData.push({ key:"program", value:program });

        search.setValuesSearch(searchData)
        search.Buscar();
    }

    return (
        <>
            <Card>
                <CardBody>
                    <Form onSubmit={SubmitController}>
                        <Row>
                            <Col xs={12} md={6} lg={4} xl={3}>
                                <Select
                                    name={`Categoria`}
                                    change={setCategory}
                                    valueChange={category}
                                    list={search.categories}
                                />
                            </Col>
                            <Col xs={12} md={6} lg={4} xl={3}>
                                <Select
                                    name={`Programas`}
                                    change={setProgram}
                                    valueChange={program}
                                    list={search.programs}
                                />
                            </Col>
                            <Col xs={12} md={6} lg={4} xl={3}>
                                <Select
                                    name={`Lineas de investigación`}
                                    change={setInvestigationLine}
                                    valueChange={investigationLine}
                                    list={search.investigationLine}
                                />
                            </Col>
                            <Col xs={12} md={6} lg={4} xl={3} className='d-flex justify-content-center align-items-center'>
                                <Button
                                    customClass="btn btn-primary"
                                    type='submit'
                                >
                                    buscar
                                </Button>
                                <Form.Select className='form-control' onChange={(e)=>search.setLimit(parseInt(e.target.value))} defaultValue={search.limit}>
                                    <option value={5}>5</option>
                                    <option value={10}>10</option>
                                    <option value={15}>15</option>
                                    <option value={20}>20</option>
                                    <option value={25}>25</option>
                                    <option value={30}>30</option>
                                </Form.Select>
                            </Col>
                        </Row>
                    </Form>
                </CardBody>
            </Card>
        </>
    )
}

export default Brand;
