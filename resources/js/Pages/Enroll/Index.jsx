import React, {useEffect, useState} from 'react';
import GuestLayout from "@/Layouts/GuestLayout.jsx";
import {Deferred, Head, useForm} from "@inertiajs/react";
import InputLabel from "@/Components/InputLabel.jsx";
import TextInput from "@/Components/TextInput.jsx";
import InputError from "@/Components/InputError.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import {Select} from "@headlessui/react";
import {ChevronDownIcon} from '@heroicons/react/20/solid'
import clsx from "clsx";
import Verification from "@/Components/Verification";


function Index({vaccineCenters, toVerify}) {

    const [verifying, setVerifying] = useState(null);
    const [verified, setVerified] = useState([]);

    const {data, setData, post, processing, errors, reset} = useForm({
        name: 'Tamim ' + Math.round(Math.random() * 100),
        email: 'test@gmail.com',
        phone: '01877085620',
        nid: '1234567' + Math.floor(Math.random() * (999 - 100 + 1) + 100),
        dob: '1998-12-14',
        vaccine_center_id: Math.round(Math.random()) + 1
    });

    const isVerified = () => {
        if (!toVerify || 0 >= toVerify.length) {
            return true;
        }
        return toVerify.every((value) => {
            return verified.includes(value)
        })
    }

    const nextVerification = () => {
        if (!toVerify || 0 >= toVerify.length) {
            return;
        }
        let shouldVerify = null
        for (let index = 0; index < toVerify.length; index++) {
            if (!verified.includes(toVerify[index])) {
                shouldVerify = toVerify[index]
                break;
            }
        }
        setVerifying(shouldVerify)
    }

    const onChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const submit = (e) => {
        e?.preventDefault();

        if (!isVerified()) {
            // alert('Please verify all the required field!')
            nextVerification();
            return;
        }
        setVerifying(false)

        post(route('enroll.store'), {
            onSuccess: () => reset('name', 'nid', 'dob'),
        });
    };

    const onVerified = (field, value) => {
        setVerified((prevState) => {
            return [...prevState, field]
        })
    }

    useEffect(() => {
        if (verifying) {
            submit();
        }
    }, [verified])

    useEffect(() => {
        setVerified((prevState) => {
            return prevState.filter((value) => value !== 'email')
        })
    }, [data.email]);

    useEffect(() => {
        setVerified((prevState) => {
            return prevState.filter((value) => value !== 'phone')
        })
    }, [data.phone]);

    return (
        <GuestLayout>
            <Head title='Enroll'/>
            <div
                className="mt-6 md:mt-12 lg:mt-16 mx-auto w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg">
                {!verifying && <form onSubmit={submit}>
                    <div>
                        <InputLabel htmlFor="name" value="Name"/>

                        <TextInput
                            id="name"
                            name="name"
                            value={data.name}
                            className="mt-1 block w-full"
                            autoComplete="name"
                            isFocused={true}
                            onChange={onChange}
                        />

                        <InputError message={errors.name} className="mt-2"/>
                    </div>

                    <div className="mt-4">
                        <InputLabel htmlFor="email" value="Email"/>

                        <TextInput
                            id="email"
                            type="email"
                            name="email"
                            value={data.email}
                            className="mt-1 block w-full"
                            autoComplete="username"
                            onChange={onChange}
                        />

                        <InputError message={errors.email} className="mt-2"/>
                    </div>

                    <div className="mt-4">
                        <InputLabel htmlFor="phone" value="Phone"/>

                        <TextInput
                            id="phone"
                            type="tel"
                            name="phone"
                            value={data.phone}
                            className="mt-1 block w-full"
                            onChange={onChange}
                        />

                        <InputError message={errors.phone} className="mt-2"/>
                    </div>

                    <div className="mt-4">
                        <InputLabel htmlFor="nid" value="NID"/>

                        <TextInput
                            id="nid"
                            type="text"
                            name="nid"
                            value={data.nid}
                            className="mt-1 block w-full"
                            onChange={onChange}
                        />

                        <InputError message={errors.nid} className="mt-2"/>
                    </div>

                    <div className="mt-4">
                        <InputLabel htmlFor="dob" value="DATE OF BIRTH"/>

                        <TextInput
                            id="dob"
                            type="date"
                            name="dob"
                            value={data.dob}
                            className="mt-1 block w-full"
                            onChange={onChange}
                        />

                        <InputError message={errors.dob} className="mt-2"/>
                    </div>

                    <div className="mt-4">
                        <InputLabel htmlFor="vaccine_center_id" value="Vccine Center"/>
                        <div className="relative">
                            <Deferred data="vaccineCenters" fallback={<div>Loading...</div>}>
                                <Select
                                    className={clsx(
                                        'rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 w-full'
                                    )}
                                    id='vaccine_center_id'
                                    name='vaccine_center_id'
                                    onChange={onChange}
                                >
                                    <option value="">Select Vaccine Center</option>
                                    {vaccineCenters && vaccineCenters.map((center) => {
                                        return <option key={center.id.toString()}
                                                       value={center.id || ''}>{center.name || ''}</option>
                                    })}
                                </Select>
                                <ChevronDownIcon
                                    className="group pointer-events-none absolute top-2.5 right-2.5 size-4 fill-white/60"
                                    aria-hidden="true"
                                />
                            </Deferred>
                        </div>
                        <InputError message={errors.vaccine_center_id} className="mt-2"/>
                    </div>

                    <div className="mt-4 flex items-center justify-end">
                        <PrimaryButton className="ms-4" disabled={processing}>
                            {isVerified() ? 'Submit' : 'Next'}
                        </PrimaryButton>
                    </div>
                </form>}
                {verifying && data[verifying] &&
                    <Verification
                        nid={data.nid}
                        fieldName={verifying}
                        fieldValue={data[verifying]}
                        onVerified={onVerified}
                    />}
            </div>
        </GuestLayout>
    );
}

export default Index;
