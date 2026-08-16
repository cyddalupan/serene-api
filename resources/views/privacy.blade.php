@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')
    <h1>Privacy Policy</h1>
    <p class="updated">Last updated: {{ date('F j, Y') }}</p>

    <p>
        Serene ("we", "us") provides an employee development and performance platform
        used by companies ("your employer") to support the growth of their employees.
        This Privacy Policy explains what information we process, why we process it,
        and the choices available to you.
    </p>

    <h2>1. Who We Are</h2>
    <p>
        Serene is a platform that companies subscribe to on behalf of their employees.
        When you use Serene through your employer, your employer is the organization
        that decides how your data is used within Serene. We process your information
        to provide and operate the platform on their behalf.
    </p>

    <h2>2. Information We Collect</h2>
    <ul>
        <li><strong>Account information</strong> — name, email address, position/role, and company membership.</li>
        <li><strong>Profile &amp; development data</strong> — employee profile, attribute scores, assessment results, and development history.</li>
        <li><strong>Activity data</strong> — training progress and attempts, quests, daily habits, reflections, and streak history.</li>
        <li><strong>Device &amp; usage data</strong> — device type, app version, and basic usage information needed to keep the app working and syncing correctly.</li>
        <li><strong>Authentication data</strong> — credentials are stored securely on your device; we never store raw passwords.</li>
    </ul>

    <h2>3. How We Use Your Information</h2>
    <ul>
        <li>To operate the platform: authentication, synchronization, and delivering training, quests, and habits.</li>
        <li>To calculate attribute scores and track development progress over time.</li>
        <li>To generate reports for your employer's administrators.</li>
        <li>To keep the service secure, reliable, and improving (e.g., audit logs, troubleshooting).</li>
    </ul>

    <h2>4. Legal Basis</h2>
    <p>
        We process personal data to perform our contract with your employer, to
        comply with legal obligations, and where applicable, based on legitimate
        interests in operating and securing the platform. Where required by law,
        we will ask for consent before processing.
    </p>

    <h2>5. How We Share Information</h2>
    <ul>
        <li><strong>Your employer</strong> — data collected through Serene is available to your employer's authorized administrators for legitimate HR and development purposes.</li>
        <li><strong>Service providers</strong> — we use hosting and infrastructure providers who process data only on our instructions.</li>
        <li><strong>Legal requirements</strong> — we may disclose information when required by law or to protect the rights and safety of our users.</li>
    </ul>
    <p>We do not sell your personal information.</p>

    <h2>6. Data Security</h2>
    <p>
        We protect your data with encryption in transit (HTTPS), strict access
        controls, server-side validation of all actions, and audit logging of
        administrative activity. Your device stores a local working copy of your
        data, which is synchronized with the server as the authoritative source.
    </p>

    <h2>7. Data Retention</h2>
    <p>
        We retain your data for as long as your employer maintains an active
        subscription, or as required to comply with legal obligations. When an
        employee account is deactivated, the data is handled in accordance with
        your employer's instructions and applicable law.
    </p>

    <h2>8. Your Rights</h2>
    <p>
        Depending on your location, you may have the right to access, correct,
        delete, or obtain a copy of your personal data, and to object to or
        restrict certain processing. Because Serene is provided through your
        employer, you can also contact your employer's administrator for
        assistance. We will respond to verified requests within the timeframes
        required by law.
    </p>

    <h2>9. Children</h2>
    <p>
        Serene is intended for use by adults in a professional context. We do not
        knowingly collect personal information from children.
    </p>

    <h2>10. Contact Us</h2>
    <p>
        If you have questions about this Privacy Policy or your personal data,
        contact us at:
    </p>
    <div class="contact-box">
        <strong>Privacy contact:</strong> <code>cydmdalupan@gmail.com</code><br>
        Serene · serene.toybits.cloud
    </div>
@endsection
