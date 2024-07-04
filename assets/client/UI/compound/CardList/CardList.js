import React, { useEffect, useState } from 'react';
import { Card, CardBody, Col, Row } from 'react-bootstrap';
import Button from '../../atoms/Button/Button';

export default function CardList({ data }) {

    const [date, setDate] = useState();

    useEffect(() => {
        const dateObject = new Date(data.date.timestamp * 1000); // convert timestamp to milliseconds
        const formattedDate = `${dateObject.toLocaleDateString()} ${dateObject.toLocaleTimeString()}`;
        setDate(formattedDate);
    }, [])

    console.log(data.title, data.document.path);

    return (
        <Col xs={12} lg={6} className='mt-3'>
            <Card>
                <Card.Body>
                    <Card.Title className='border-bottom pb-2'>
                        {data.title}
                    </Card.Title>

                    <Row className='h-full'>
                        <Col className='m-auto'>
                            <Card.Subtitle>Autor: {data.user.fullName}</Card.Subtitle>
                            <Card.Subtitle className='mt-2'>{date}</Card.Subtitle>
                        </Col>
                        <Col className='m-auto'>
                            <Button
                                customClass="btn btn-primary"
                            >
                                ver
                            </Button>
                            <a
                                href={`/${data.document.webPath}`}
                                download={data.title}
                            >
                                {
                                    data.downloader &&
                                    <Button
                                        variant='danger'
                                    >
                                        descargar
                                    </Button>
                                }
                                
                            </a>
                        </Col>
                    </Row>
                </Card.Body>
            </Card>
        </Col>
    );
}
