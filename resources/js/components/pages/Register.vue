<template>
  <div>
    <div class="offset-sm-2 offset-lg-3 col-sm-8 col-lg-6">
      <div class="card mt-5">
        <div class="card-body">
          <div class="row">
            <div
              v-if="is_search_inviter"
              class="col-sm-12 fetch_inviter_wrapper"
            >
              <div class="completed">
                <h3 class="mt-3 mb-3 border-bottom">
                  <div
                    class="
                      rounded-circle
                      bg-success
                      text-center text-white
                      d-inline-block
                    "
                    style="width: 35px; height: 35px; padding-top: 3px"
                  >
                    1
                  </div>
                  <span class="label">Search Inviter</span>
                </h3>
              </div>
              <div id="fetch_inviter_container">
                <div class="background-highlight">
                  <div class="row">
                    <div class="col-sm-12">
                      <form class="form-horizontal" _lpchecked="1">
                        <div class="form-group row d-flex">
                          <label
                            class="text-bold col-sm-3 col-form-label"
                            for="exampleInputEmail1"
                            >Enter Your Inviter Details</label
                          >
                          <div class="col-sm-9">
                            <small id="emailHelp" class="form-text text-muted"
                              >Enter Your Inviter's Username or Email.</small
                            ><input
                              type="text"
                              class="inviter-field form-control form-control-sm"
                              id="inputUsername"
                              placeholder="Username"
                              autocomplete="off"
                              v-model="inviter_username"
                            />
                          </div>
                        </div>
                        <a
                          class="
                            btn btn-secondary btn-sm
                            text-white
                            search-button
                          "
                          @click="searchInviter"
                        >
                          CLICK HERE TO CONTINUE
                        </a>
                      </form>
                    </div>
                    <div
                      v-if="inviter_result && inviter_search"
                      class="alert alert-success col-sm-12 p-2 m-3"
                    >
                      <h5>Selected Inviter</h5>
                      <div>
                        <b> Name: </b> {{ user.firstName }}
                        {{ user.lastName }}
                      </div>
                      <div><b> Username: </b> {{ user.username }}</div>
                      <div><b> Phone: </b> {{ user.phone }}</div>
                      <div><b> Email: </b> {{ user.email }}</div>
                    </div>
                    <div
                      v-if="!inviter_result && inviter_search"
                      class="alert alert-danger col-sm-12 p-2 m-3"
                    >
                      <h3 class="text-danger">
                        Member [ {{ inviter_username_searched }} ] not Found.
                      </h3>
                    </div>

                    <a
                      v-if="inviter_result && inviter_search"
                      class="btn btn-secondary btn-sm text-white search-button"
                      @click="continueToRegistration"
                    >
                      CONTINUE TO REGISTRATION
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <div v-else class="next-step col-sm-12 p-2">
              <div class="row">
                <div class="col-sm-12 completed">
                  <h3 class="mt-3 mb-3 border-bottom">
                    <div
                      class="
                        rounded-circle
                        bg-success
                        text-center text-white
                        d-inline-block
                      "
                      style="width: 35px; height: 35px; padding-top: 3px"
                    >
                      2
                    </div>
                    <span class="label">Registration</span>
                  </h3>
                </div>

                <div class="col-sm-12">
                  <div class="alert alert-primary" role="alert">
                    Account Detail
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row mb-0 d-flex">
                    <label
                      for="registration_first_name"
                      class="col-sm-3 col-form-label"
                      ><b>First Name</b></label
                    >
                    <div class="col-sm-7">
                      <div class="form-group">
                        <label class="sr-only" for="id_first_name"
                          >First name</label
                        >
                        <div class="registration_first_name">
                          <input
                            type="text"
                            name="first_name"
                            required="true"
                            maxlength="30"
                            class="form-control"
                            placeholder="First name"
                            title=""
                            v-model="first_name"
                            id="id_first_name"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row mb-0 d-flex">
                    <label
                      for="registration_last_name"
                      class="col-sm-3 col-form-label"
                      ><b>Last Name</b></label
                    >
                    <div class="col-sm-7">
                      <div class="form-group">
                        <label class="sr-only" for="id_last_name"
                          >Last name</label
                        >
                        <div class="registration_last_name">
                          <input
                            type="text"
                            name="last_name"
                            required="true"
                            maxlength="150"
                            class="form-control"
                            placeholder="Last name"
                            title=""
                            v-model="last_name"
                            id="id_last_name"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row mb-0 d-flex">
                    <label
                      for="registration_username"
                      class="col-sm-3 col-form-label"
                      ><b>Username</b></label
                    >
                    <div class="col-sm-7">
                      <div class="form-group">
                        <label class="sr-only" for="id_username"
                          >Username</label
                        >
                        <div class="registration_username">
                          <input
                            type="text"
                            name="username"
                            required=""
                            maxlength="150"
                            class="form-control"
                            placeholder="Username"
                            title=""
                            id="id_username"
                            v-model="username"
                            autocomplete="off"
                          />
                        </div>
                      </div>
                      <div style="clear: both"></div>
                      <div class="username-register-warning"></div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row mb-0 d-flex">
                    <label
                      for="registration_password"
                      class="col-sm-3 col-form-label"
                      ><b>Password</b></label
                    >
                    <div class="col-sm-7">
                      <div class="form-group">
                        <label class="sr-only" for="id_password"
                          >Password</label
                        >
                        <div class="registration_password">
                          <input
                            type="password"
                            name="password"
                            required=""
                            maxlength="128"
                            class="form-control"
                            placeholder="Password"
                            v-model="password"
                            title=""
                            id="id_password"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row mb-0 d-flex">
                    <label
                      for="registration_password_again"
                      class="col-sm-3 col-form-label"
                      ><b>Password Again</b></label
                    >
                    <div class="col-sm-7">
                      <div class="form-group">
                        <label class="sr-only" for="id_password_again"
                          >Password again</label
                        >
                        <div class="registration_password_again">
                          <input
                            type="password"
                            name="password_again"
                            required="true"
                            maxlength="255"
                            class="form-control"
                            placeholder="Password again"
                            v-model="password_again"
                            title=""
                            id="id_password_again"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row mb-0 d-flex">
                    <label
                      for="registration_email"
                      class="col-sm-3 col-form-label"
                      ><b>Email</b></label
                    >
                    <div class="col-sm-7">
                      <div class="form-group">
                        <label class="sr-only" for="id_email"
                          >Email address</label
                        >
                        <div class="registration_email">
                          <input
                            type="email"
                            name="email"
                            required="true"
                            maxlength="254"
                            class="form-control"
                            placeholder="Email address"
                            v-model="email"
                            title=""
                            id="id_email"
                          />
                        </div>
                      </div>
                      <div style="clear: both"></div>
                      <div class="email-register-warning"></div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row mb-0 d-flex">
                    <label
                      for="registration_email_again"
                      class="col-sm-3 col-form-label"
                      ><b>Email Again</b></label
                    >
                    <div class="col-sm-7">
                      <div class="form-group">
                        <label class="sr-only" for="id_email_again"
                          >Email again</label
                        >
                        <div class="registration_email_again">
                          <input
                            type="email"
                            name="email_again"
                            required="true"
                            maxlength="255"
                            class="form-control"
                            placeholder="Email again"
                            v-model="email_again"
                            title=""
                            id="id_email_again"
                          />
                        </div>
                      </div>
                      <div style="clear: both"></div>
                      <div class="emailagain-register-warning"></div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row mb-0 d-flex">
                    <label
                      for="registration_gender"
                      class="col-sm-3 col-form-label"
                      ><b>Gender</b></label
                    >
                    <div class="col-sm-7">
                      <div class="form-group">
                        <label class="sr-only" for="id_gender_0">Gender</label>
                        <div class="registration_gender">
                          <div class="gender" id="id_gender">
                            <div class="form-check">
                              <label for="id_gender_0"
                                ><input
                                  checked=""
                                  class="gender"
                                  id="id_gender_0"
                                  name="gender"
                                  required=""
                                  title=""
                                  v-model="gender"
                                  type="radio"
                                  value="0"
                                />
                                male</label
                              >
                            </div>
                            <div class="form-check">
                              <label for="id_gender_1"
                                ><input
                                  class="gender"
                                  id="id_gender_1"
                                  name="gender"
                                  required=""
                                  title=""
                                  v-model="gender"
                                  type="radio"
                                  value="1"
                                />
                                female</label
                              >
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="alert alert-primary" role="alert">
                    Personal Detail
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row mb-0 d-flex">
                    <label
                      for="registration_gender"
                      class="col-sm-3 col-form-label"
                      ><b>Date Of Birth</b></label
                    >
                    <div class="col-sm-7">
                      <div class="row">
                        <div class="col-2 registration_date_wrapper">
                          <div class="form-group">
                            <label class="sr-only" for="id_date">Date</label>
                            <div class="registration_date">
                              <select
                                name="date"
                                required="true"
                                class="form-control"
                                title=""
                                v-model="date"
                                id="id_date"
                              >
                                <option value="1" selected="">1</option>

                                <option value="2">2</option>

                                <option value="3">3</option>

                                <option value="4">4</option>

                                <option value="5">5</option>

                                <option value="6">6</option>

                                <option value="7">7</option>

                                <option value="8">8</option>

                                <option value="9">9</option>

                                <option value="10">10</option>

                                <option value="11">11</option>

                                <option value="12">12</option>

                                <option value="13">13</option>

                                <option value="14">14</option>

                                <option value="15">15</option>

                                <option value="16">16</option>

                                <option value="17">17</option>

                                <option value="18">18</option>

                                <option value="19">19</option>

                                <option value="20">20</option>

                                <option value="21">21</option>

                                <option value="22">22</option>

                                <option value="23">23</option>

                                <option value="24">24</option>

                                <option value="25">25</option>

                                <option value="26">26</option>

                                <option value="27">27</option>

                                <option value="28">28</option>

                                <option value="29">29</option>

                                <option value="30">30</option>

                                <option value="31">31</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-5 registration_month_wrapper">
                          <div class="form-group">
                            <label class="sr-only" for="id_month">Month</label>
                            <div class="registration_month">
                              <select
                                name="month"
                                required="true"
                                class="form-control"
                                title=""
                                v-model="month"
                                id="id_month"
                              >
                                <option value="1" selected="">January</option>

                                <option value="2">February</option>

                                <option value="3">March</option>

                                <option value="4">April</option>

                                <option value="5">May</option>

                                <option value="6">June</option>

                                <option value="7">July</option>

                                <option value="8">August</option>

                                <option value="9">September</option>

                                <option value="10">October</option>

                                <option value="11">November</option>

                                <option value="12">December</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-3 registration_year_wrapper">
                          <div class="form-group">
                            <label class="sr-only" for="id_year">Year</label>
                            <div class="registration_year">
                              <select
                                name="year"
                                required="true"
                                class="form-control"
                                title=""
                                v-model="year"
                                id="id_year"
                              >
                                <option value="1930">1930</option>

                                <option value="1931">1931</option>

                                <option value="1932">1932</option>

                                <option value="1933">1933</option>

                                <option value="1934">1934</option>

                                <option value="1935">1935</option>

                                <option value="1936">1936</option>

                                <option value="1937">1937</option>

                                <option value="1938">1938</option>

                                <option value="1939">1939</option>

                                <option value="1940">1940</option>

                                <option value="1941">1941</option>

                                <option value="1942">1942</option>

                                <option value="1943">1943</option>

                                <option value="1944">1944</option>

                                <option value="1945">1945</option>

                                <option value="1946">1946</option>

                                <option value="1947">1947</option>

                                <option value="1948">1948</option>

                                <option value="1949">1949</option>

                                <option value="1950">1950</option>

                                <option value="1951">1951</option>

                                <option value="1952">1952</option>

                                <option value="1953">1953</option>

                                <option value="1954">1954</option>

                                <option value="1955">1955</option>

                                <option value="1956">1956</option>

                                <option value="1957">1957</option>

                                <option value="1958">1958</option>

                                <option value="1959">1959</option>

                                <option value="1960">1960</option>

                                <option value="1961">1961</option>

                                <option value="1962">1962</option>

                                <option value="1963">1963</option>

                                <option value="1964">1964</option>

                                <option value="1965">1965</option>

                                <option value="1966">1966</option>

                                <option value="1967">1967</option>

                                <option value="1968">1968</option>

                                <option value="1969">1969</option>

                                <option value="1970">1970</option>

                                <option value="1971">1971</option>

                                <option value="1972">1972</option>

                                <option value="1973">1973</option>

                                <option value="1974">1974</option>

                                <option value="1975">1975</option>

                                <option value="1976">1976</option>

                                <option value="1977">1977</option>

                                <option value="1978">1978</option>

                                <option value="1979">1979</option>

                                <option value="1980">1980</option>

                                <option value="1981">1981</option>

                                <option value="1982">1982</option>

                                <option value="1983">1983</option>

                                <option value="1984">1984</option>

                                <option value="1985">1985</option>

                                <option value="1986">1986</option>

                                <option value="1987">1987</option>

                                <option value="1988">1988</option>

                                <option value="1989">1989</option>

                                <option value="1990">1990</option>

                                <option value="1991">1991</option>

                                <option value="1992">1992</option>

                                <option value="1993">1993</option>

                                <option value="1994">1994</option>

                                <option value="1995">1995</option>

                                <option value="1996">1996</option>

                                <option value="1997">1997</option>

                                <option value="1998">1998</option>

                                <option value="1999">1999</option>

                                <option value="2000" selected="">2000</option>

                                <option value="2001">2001</option>

                                <option value="2002">2002</option>

                                <option value="2003">2003</option>

                                <option value="2004">2004</option>

                                <option value="2005">2005</option>

                                <option value="2006">2006</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row mb-0 d-flex">
                    <label
                      for="registration_gender"
                      class="col-sm-3 col-form-label"
                      ><b>Your Country</b></label
                    >
                    <div class="col-sm-7">
                      <div class="form-group">
                        <label class="sr-only" for="id_country">Country</label>
                        <div class="registration_country">
                          <select
                            name="country"
                            required="true"
                            class="form-control"
                            title=""
                            v-model="country"
                            id="id_country"
                          >
                            <option value="" selected="">---------</option>

                            <option value="3">Afghanistan</option>

                            <option value="15">Åland Islands</option>

                            <option value="6">Albania</option>

                            <option value="62">Algeria</option>

                            <option value="11">American Samoa</option>

                            <option value="1">Andorra</option>

                            <option value="8">Angola</option>

                            <option value="5">Anguilla</option>

                            <option value="9">Antarctica</option>

                            <option value="4">Antigua and Barbuda</option>

                            <option value="10">Argentina</option>

                            <option value="7">Armenia</option>

                            <option value="14">Aruba</option>

                            <option value="13">Australia</option>

                            <option value="12">Austria</option>

                            <option value="16">Azerbaijan</option>

                            <option value="32">Bahamas</option>

                            <option value="23">Bahrain</option>

                            <option value="19">Bangladesh</option>

                            <option value="18">Barbados</option>

                            <option value="36">Belarus</option>

                            <option value="20">Belgium</option>

                            <option value="37">Belize</option>

                            <option value="25">Benin</option>

                            <option value="27">Bermuda</option>

                            <option value="33">Bhutan</option>

                            <option value="29">Bolivia</option>

                            <option value="30">
                              Bonaire, Sint Eustatius and Saba
                            </option>

                            <option value="17">Bosnia and Herzegovina</option>

                            <option value="35">Botswana</option>

                            <option value="34">Bouvet Island</option>

                            <option value="31">Brazil</option>

                            <option value="107">
                              British Indian Ocean Territory
                            </option>

                            <option value="240">British Virgin Islands</option>

                            <option value="28">Brunei</option>

                            <option value="22">Bulgaria</option>

                            <option value="21">Burkina Faso</option>

                            <option value="24">Burundi</option>

                            <option value="118">Cambodia</option>

                            <option value="47">Cameroon</option>

                            <option value="38">Canada</option>

                            <option value="52">Cape Verde</option>

                            <option value="125">Cayman Islands</option>

                            <option value="41">Central African Republic</option>

                            <option value="216">Chad</option>

                            <option value="46">Chile</option>

                            <option value="48">China</option>

                            <option value="54">Christmas Island</option>

                            <option value="39">Cocos Islands</option>

                            <option value="49">Colombia</option>

                            <option value="120">Comoros</option>

                            <option value="42">Congo</option>

                            <option value="45">Cook Islands</option>

                            <option value="50">Costa Rica</option>

                            <option value="44">Côte dIvoire</option>

                            <option value="99">Croatia</option>

                            <option value="51">Cuba</option>

                            <option value="53">Curaçao</option>

                            <option value="55">Cyprus</option>

                            <option value="56">Czech Republic</option>

                            <option value="59">Denmark</option>

                            <option value="58">Djibouti</option>

                            <option value="60">Dominica</option>

                            <option value="61">Dominican Republic</option>

                            <option value="40">DR Congo</option>

                            <option value="63">Ecuador</option>

                            <option value="65">Egypt</option>

                            <option value="211">El Salvador</option>

                            <option value="89">Equatorial Guinea</option>

                            <option value="67">Eritrea</option>

                            <option value="64">Estonia</option>

                            <option value="69">Ethiopia</option>

                            <option value="70">European Union</option>

                            <option value="73">Falkland Islands</option>

                            <option value="75">Faroe Islands</option>

                            <option value="72">Fiji</option>

                            <option value="71">Finland</option>

                            <option value="76">France</option>

                            <option value="81">French Guiana</option>

                            <option value="176">French Polynesia</option>

                            <option value="217">
                              French Southern Territories
                            </option>

                            <option value="77">Gabon</option>

                            <option value="86">Gambia</option>

                            <option value="80">Georgia</option>

                            <option value="57">Germany</option>

                            <option value="83">Ghana</option>

                            <option value="84">Gibraltar</option>

                            <option value="90">Greece</option>

                            <option value="85">Greenland</option>

                            <option value="79">Grenada</option>

                            <option value="88">Guadeloupe</option>

                            <option value="93">Guam</option>

                            <option value="92">Guatemala</option>

                            <option value="82">Guernsey</option>

                            <option value="87">Guinea</option>

                            <option value="94">Guinea-Bissau</option>

                            <option value="95">Guyana</option>

                            <option value="100">Haiti</option>

                            <option value="97">
                              Heard Island and McDonald Islands
                            </option>

                            <option value="98">Honduras</option>

                            <option value="96">Hong Kong</option>

                            <option value="101">Hungary</option>

                            <option value="110">Iceland</option>

                            <option value="106">India</option>

                            <option value="102">Indonesia</option>

                            <option value="109">Iran</option>

                            <option value="108">Iraq</option>

                            <option value="103">Ireland</option>

                            <option value="105">Isle of Man</option>

                            <option value="104">Israel</option>

                            <option value="111">Italy</option>

                            <option value="113">Jamaica</option>

                            <option value="115">Japan</option>

                            <option value="112">Jersey</option>

                            <option value="114">Jordan</option>

                            <option value="126">Kazakhstan</option>

                            <option value="116">Kenya</option>

                            <option value="119">Kiribati</option>

                            <option value="124">Kuwait</option>

                            <option value="117">Kyrgyzstan</option>

                            <option value="127">Laos</option>

                            <option value="136">Latvia</option>

                            <option value="128">Lebanon</option>

                            <option value="133">Lesotho</option>

                            <option value="132">Liberia</option>

                            <option value="137">Libya</option>

                            <option value="130">Liechtenstein</option>

                            <option value="134">Lithuania</option>

                            <option value="135">Luxembourg</option>

                            <option value="149">Macao</option>

                            <option value="145">Macedonia</option>

                            <option value="143">Madagascar</option>

                            <option value="157">Malawi</option>

                            <option value="159">Malaysia</option>

                            <option value="156">Maldives</option>

                            <option value="146">Mali</option>

                            <option value="154">Malta</option>

                            <option value="144">Marshall Islands</option>

                            <option value="151">Martinique</option>

                            <option value="152">Mauritania</option>

                            <option value="155">Mauritius</option>

                            <option value="247">Mayotte</option>

                            <option value="158">Mexico</option>

                            <option value="74">Micronesia</option>

                            <option value="140">Moldova</option>

                            <option value="139">Monaco</option>

                            <option value="148">Mongolia</option>

                            <option value="141">Montenegro</option>

                            <option value="153">Montserrat</option>

                            <option value="138">Morocco</option>

                            <option value="160">Mozambique</option>

                            <option value="147">Myanmar</option>

                            <option value="161">Namibia</option>

                            <option value="170">Nauru</option>

                            <option value="169">Nepal</option>

                            <option value="167">Netherlands</option>

                            <option value="162">New Caledonia</option>

                            <option value="172">New Zealand</option>

                            <option value="166">Nicaragua</option>

                            <option value="163">Niger</option>

                            <option value="165">Nigeria</option>

                            <option value="171">Niue</option>

                            <option value="164">Norfolk Island</option>

                            <option value="150">
                              Northern Mariana Islands
                            </option>

                            <option value="122">North Korea</option>

                            <option value="168">Norway</option>

                            <option value="173">Oman</option>

                            <option value="179">Pakistan</option>

                            <option value="186">Palau</option>

                            <option value="184">Palestine</option>

                            <option value="174">Panama</option>

                            <option value="177">Papua New Guinea</option>

                            <option value="187">Paraguay</option>

                            <option value="175">Peru</option>

                            <option value="178">Philippines</option>

                            <option value="182">Pitcairn</option>

                            <option value="180">Poland</option>

                            <option value="185">Portugal</option>

                            <option value="183">Puerto Rico</option>

                            <option value="188">Qatar</option>

                            <option value="189">Réunion</option>

                            <option value="190">Romania</option>

                            <option value="192">Russia</option>

                            <option value="193">Rwanda</option>

                            <option value="26">Saint Barthélemy</option>

                            <option value="200">
                              Saint Helena, Ascension and Tristan da Cunha
                            </option>

                            <option value="121">Saint Kitts and Nevis</option>

                            <option value="129">Saint Lucia</option>

                            <option value="142">Saint Martin</option>

                            <option value="181">
                              Saint Pierre and Miquelon
                            </option>

                            <option value="238">
                              Saint Vincent and the Grenadines
                            </option>

                            <option value="245">Samoa</option>

                            <option value="205">San Marino</option>

                            <option value="210">Sao Tome and Principe</option>

                            <option value="194">Saudi Arabia</option>

                            <option value="206">Senegal</option>

                            <option value="191">Serbia</option>

                            <option value="196">Seychelles</option>

                            <option value="204">Sierra Leone</option>

                            <option value="199">Singapore</option>

                            <option value="212">Sint Maarten</option>

                            <option value="203">Slovakia</option>

                            <option value="201">Slovenia</option>

                            <option value="195">Solomon Islands</option>

                            <option value="207">Somalia</option>

                            <option value="248">South Africa</option>

                            <option value="91">
                              South Georgia and the South Sandwich Islands
                            </option>

                            <option value="123">South Korea</option>

                            <option value="209">South Sudan</option>

                            <option value="68">Spain</option>

                            <option value="131">Sri Lanka</option>

                            <option value="197">Sudan</option>

                            <option value="208">Suriname</option>

                            <option value="202">Svalbard and Jan Mayen</option>

                            <option value="214">Swaziland</option>

                            <option value="198">Sweden</option>

                            <option value="43">Switzerland</option>

                            <option value="213">Syrian Arab Republic</option>

                            <option value="229">Taiwan</option>

                            <option value="220">Tajikistan</option>

                            <option value="230">Tanzania</option>

                            <option value="219">Thailand</option>

                            <option value="222">Timor-Leste</option>

                            <option value="218">Togo</option>

                            <option value="221">Tokelau</option>

                            <option value="225">Tonga</option>

                            <option value="227">Trinidad and Tobago</option>

                            <option value="224">Tunisia</option>

                            <option value="226">Turkey</option>

                            <option value="223">Turkmenistan</option>

                            <option value="215">
                              Turks and Caicos Islands
                            </option>

                            <option value="228">Tuvalu</option>

                            <option value="232">Uganda</option>

                            <option value="231">Ukraine</option>

                            <option value="2">United Arab Emirates</option>

                            <option value="78">United Kingdom</option>

                            <option value="234">United States</option>

                            <option value="235">Uruguay</option>

                            <option value="233">
                              U.S. Minor Outlying Islands
                            </option>

                            <option value="241">U.S. Virgin Islands</option>

                            <option value="236">Uzbekistan</option>

                            <option value="243">Vanuatu</option>

                            <option value="237">Vatican City</option>

                            <option value="239">Venezuela</option>

                            <option value="242">Vietnam</option>

                            <option value="244">Wallis and Futuna</option>

                            <option value="66">Western Sahara</option>

                            <option value="246">Yemen</option>

                            <option value="249">Zambia</option>

                            <option value="250">Zimbabwe</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row mb-0 d-flex">
                    <label
                      for="registration_gender"
                      class="col-sm-3 col-form-label"
                      ><b>Your Location</b></label
                    >
                    <div class="col-sm-7">
                      <div class="form-group">
                        <select
                          class="form-control"
                          id="id_location"
                          name="location"
                          title=""
                          v-model="location"
                        >
                          <option selected="" value="">---------</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row mb-0 d-flex">
                    <label
                      for="registration_town"
                      class="col-sm-3 col-form-label"
                      ><b>Your City/Town</b></label
                    >
                    <div class="col-sm-7">
                      <div class="form-group">
                        <label class="sr-only" for="id_town">Town</label>
                        <div class="registration_town">
                          <input
                            type="text"
                            name="town"
                            maxlength="255"
                            class="form-control"
                            placeholder="Town"
                            title=""
                            v-model="town"
                            id="id_town"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row mb-0 d-flex">
                    <label
                      for="registration_phone"
                      class="col-sm-3 col-form-label"
                      ><b>Your Mobile Phone</b></label
                    >
                    <div class="col-sm-7">
                      <div class="form-group">
                        <label class="sr-only" for="id_phone">Phone</label>
                        <div class="registration_phone">
                          <input
                            type="text"
                            name="phone"
                            required="true"
                            maxlength="255"
                            class="form-control"
                            placeholder="Phone"
                            title=""
                            v-model="phone"
                            id="id_phone"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row mb-0 d-flex">
                    <label
                      for="registration_agreement"
                      class="col-sm-3 col-form-label"
                      ><b></b
                    ></label>
                    <div class="col-sm-7">
                      <ul>
                        <li style="list-style: none">
                          <input
                            id="agreements.4"
                            class="agreements_4"
                            name="agreements[4]"
                            type="checkbox"
                            value="4"
                            v-model="agreement1"
                            required=""
                          />
                          <small class="ml-2"
                            >I understand that Just Like any other Business GIF
                            Affiliate Business takes about 1-5 Years of FOCUSED
                            Serious Hard Work to get Reasonable Results.</small
                          >
                        </li>

                        <li style="list-style: none">
                          <input
                            id="agreements.3"
                            class="agreements_3"
                            name="agreements[3]"
                            type="checkbox"
                            value="3"
                            v-model="agreement2"
                            required=""
                          />
                          <small class="ml-2"
                            >I UNDERSTAND I HAVE TO VERIFY MY EMAIL BEFORE USING
                            GIF WEBSITE</small
                          >
                        </li>

                        <li style="list-style: none">
                          <input
                            id="agreements.2"
                            class="agreements_2"
                            name="agreements[2]"
                            type="checkbox"
                            value="2"
                            v-model="agreement3"
                            required=""
                          />
                          <small class="ml-2"
                            >I Agree to Terms of Use and Privacy Policy</small
                          >
                        </li>

                        <li style="list-style: none">
                          <input
                            id="agreements.1"
                            class="agreements_1"
                            name="agreements[1]"
                            type="checkbox"
                            value="1"
                            v-model="agreement4"
                            required=""
                          />
                          <small class="ml-2">
                            I confirm that I am registering under the correct
                            Inviter and I understand Inviter details cannot be
                            changed.</small
                          >
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="text-center reg-step-button">
            <button
              v-if="!is_search_inviter"
              class="btn btn-primary register-button mb-3"
              @click="register"
            >
              Register
            </button>
            <div>Or</div>
            <router-link
              class="btn btn-secondary btn-sm register-button mb-3"
              :to="'/login'"
            >
              Login
            </router-link>
          </div>

          <div class="cont-step-button d-none">
            <a href="/" class="btn btn-danger btn-sm m-4">CANCEL</a>
            <a href="#" class="btn btn-secondary cont_to_reg btn-sm m-4"
              >CONTINUE TO REGISTRATION</a
            >
          </div>

          <div class="col-sm-12 register-warning">
            <p>No Inviter Selected</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  created() {
    this.iframe_url = this.$base_url + "user/register/";
  },
  data: () => ({
    loading: false,
    inviter_result: false,
    inviter_id: "",
    inviter_username: "",
    inviter_username_searched: "",
    is_search_inviter: true,
    inviter_search: false,
    iframe_url: "",
    first_name: "",
    last_name: "",
    username: "",
    password: "",
    password_again: "",
    email: "",
    email_again: "",
    gender: "",
    date: "",
    month: "",
    year: "",
    country: "",
    location: "",
    town: "",
    phone: "",
    agreement1: "",
    agreement2: "",
    agreement3: "",
    agreement4: "",
    user: {
      id: "",
      firstName: "",
      lastName: "",
      username: "",
      email: "",
      phone: "",
    },
  }),
  methods: {
    continueToRegistration() {
      this.is_search_inviter = false;
    },

    searchInviter() {
      if (!this.inviter_username.length) {
        this.notification("Inviter is Null.");
        return false;
      }

      var inviter_username = this.inviter_username.toLowerCase();

      var query_str = "?inviter_username=" + inviter_username;

      window.axios.get("/user/fetch/" + query_str).then((res) => {
        const inviter = res.data;
        console.log(inviter);

        this.inviter_username_searched = this.inviter_username;
        this.is_search_inviter = true;
        this.inviter_search = true;

        if (inviter.id) {
          this.inviter_result = true;

          this.inviter_id = inviter.id;
          this.user.id = inviter.id;
          this.user.firstName = inviter.first_name;
          this.user.lastName = inviter.last_name;
          this.user.username = inviter.username;
          this.user.email = inviter.email;
          this.user.phone = inviter.phone;
        }
      });
    },
    register() {
      var error = false;
      var not_null = "must not be Null.";

      if (!this.inviter_result) {
        this.notification("No Inviter Selected.");
        error = true;
      }

      if (this.first_name == "") {
        this.notification("First Name " + not_null);
        error = true;
      }
      if (this.last_name == "") {
        this.notification("Last Name " + not_null);
        error = true;
      }
      if (this.username == "") {
        this.notification("Username " + not_null);
        error = true;
      }
      if (this.password == "") {
        this.notification("Password " + not_null);
        error = true;
      }
      if (this.password_again == "") {
        this.notification("Password Again " + not_null);
        error = true;
      }
      if (this.email == "") {
        this.notification("Email " + not_null);
        error = true;
      }
      if (this.email_again == "") {
        this.notification("Email Again " + not_null);
        error = true;
      }
      if (this.gender == "") {
        this.notification("Gender " + not_null);
        error = true;
      }
      if (this.date == "") {
        this.notification("Date " + not_null);
        error = true;
      }
      if (this.month == "") {
        this.notification("Month " + not_null);
        error = true;
      }
      if (this.year == "") {
        this.notification("Year " + not_null);
        error = true;
      }
      if (this.country == "") {
        this.notification("Country " + not_null);
        error = true;
      }
      if (this.town == "") {
        this.notification("Town " + not_null);
        error = true;
      }
      if (this.phone == "") {
        this.notification("Phone " + not_null);
        error = true;
      }
      if (this.agreement1 == "") {
        this.notification("agreement1 " + not_null);
        error = true;
      }
      if (this.agreement2 == "") {
        this.notification("agreement2 " + not_null);
        error = true;
      }
      if (this.agreement3 == "") {
        this.notification("agreement3 " + not_null);
        error = true;
      }
      if (this.agreement4 == "") {
        this.notification("agreement4 " + not_null);
        error = true;
      }

      if(error){
        return false;
      }

      this.$recaptchaLoaded().then(() => {
        console.log("recaptcha loaded");
        this.$recaptcha("login").then((token) => {
          let query_str =
            "mutation{createUser(" +
            "inviterId:" +
            this.inviter_id +
            "," +
            'firstName:"' +
            this.first_name +
            '",' +
            'lastName:"' +
            this.last_name +
            '",' +
            'username:"' +
            this.username +
            '",' +
            'password:"' +
            this.password +
            '",' +
            'email:"' +
            this.email +
            '",' +
            'gender:"' +
            this.gender +
            '",' +
            'date:"' +
            this.date +
            '",' +
            'month:"' +
            this.month +
            '",' +
            'year:"' +
            this.year +
            '",' +
            'country:"' +
            this.country +
            '",' +
            'location:"' +
            this.town +
            '",' +
            'address:"' +
            this.town +
            '",' +
            'town:"' +
            this.town +
            '",' +
            'phone:"' +
            this.phone +
            '",' +
            'token:"' +
            token +
            '"){successful,message, user{id,firstName,lastName,username,email} }}';

          var tmp_query_str =
            "?username=" +
            this.username.toLowerCase() +
            "&email=" +
            this.email.toLowerCase();

          window.axios.get("/user/checkuser/" + tmp_query_str).then((res) => {

            if (!res.data.has_error) {

              window.axios
                .post("/graphql?query=" + query_str)
                .then((response) => {

                  console.log(response);

                  if (response.data.data.createUser.successful) {
                    this.$router.push("thankyou");
                  }

                  this.notification(res.data.data.createUser.message);

                })
                .catch((response) => {

                  this.notification("Unable to contact the server.");

                  console.log(response);

                });
            } else {

              this.notification("Error:" + res.data.error_message);

            }

          });
        });
      });
    },
    checkuser(field) {

      var tmp_query_str =
          "?username=" +
          this.username.toLowerCase();

      if(field == 'email'){
        tmp_query_str =
          "?email=" +
          this.email.toLowerCase();
      }

      window.axios.get("/user/checkuser/" + tmp_query_str).then((res) => {
        if (res.data.has_error) {
          this.notification("Error:" + res.data.error_message);
        }
      });
    },
    notification(message, type = "error") {
      this.$notify({
        title: type.toUpperCase() + " MESSAGE",
        text: message,
        type: type,
      });
    },
  },
};
</script>
<style scoped lang="css">
#main-wrapper {
  overflow: scroll;
  overflow-x: hidden;
}
#login {
  height: 50%;
  width: 100%;
  position: absolute;
  top: 0;
  left: 0;
  content: "";
  z-index: 0;
}
</style>
